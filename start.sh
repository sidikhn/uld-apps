#!/bin/bash

# ==========================================
# ULD Laravel Production Start Script
# Laravel + Scheduler + Vite Build + ngrok
# ==========================================

PROJECT_DIR="$(cd "$(dirname "$0")" && pwd)"
PID_DIR="$PROJECT_DIR/.run"
LOG_DIR="$PROJECT_DIR/storage/logs"

mkdir -p "$PID_DIR"
mkdir -p "$LOG_DIR"

cd "$PROJECT_DIR" || exit 1

echo "=========================================="
echo "Starting ULD Laravel Application"
echo "=========================================="

# ------------------------------------------
# Configuration
# ------------------------------------------

LARAVEL_PORT=8000
NGROK_DOMAIN="citizen-speech-serving.ngrok-free.dev"

# ------------------------------------------
# Check existing Laravel
# ------------------------------------------

if [ -f "$PID_DIR/laravel.pid" ]; then
    OLD_PID=$(cat "$PID_DIR/laravel.pid")

    if kill -0 "$OLD_PID" 2>/dev/null; then
        echo "Laravel masih berjalan. PID: $OLD_PID"
        echo "Jalankan ./stop.sh terlebih dahulu."
        exit 1
    else
        rm -f "$PID_DIR/laravel.pid"
    fi
fi

# ------------------------------------------
# Check port 8000
# ------------------------------------------

if ss -ltn 2>/dev/null | grep -q ":$LARAVEL_PORT "; then
    echo "ERROR: Port $LARAVEL_PORT masih digunakan."
    echo "Cek dengan:"
    echo "sudo lsof -i :$LARAVEL_PORT"
    exit 1
fi

# ------------------------------------------
# Kill stale Vite development server
# ------------------------------------------

echo ""
echo "Cleaning stale Vite processes..."

pkill -f "$PROJECT_DIR/node_modules/.bin/vite" 2>/dev/null || true
pkill -f "npm run dev" 2>/dev/null || true

# Hapus Vite hot file
rm -f "$PROJECT_DIR/public/hot"

echo "Vite development server cleaned."

# ------------------------------------------
# Build Vite production assets
# ------------------------------------------

echo ""
echo "Building Vite production assets..."

npm run build

if [ $? -ne 0 ]; then
    echo "ERROR: Vite build failed!"
    exit 1
fi

echo "Vite build completed."

# ------------------------------------------
# Laravel cache
# ------------------------------------------

echo ""
echo "Clearing Laravel cache..."

php8.3 artisan optimize:clear

echo ""
echo "Caching Laravel configuration..."

php8.3 artisan config:cache

# ------------------------------------------
# Start Laravel
# ------------------------------------------

echo ""
echo "Starting Laravel..."

nohup php8.3 \
    -d upload_max_filesize=50M \
    -d post_max_size=64M \
    artisan serve \
    --host=0.0.0.0 \
    --port=$LARAVEL_PORT \
    > "$LOG_DIR/laravel-serve.log" 2>&1 &

LARAVEL_PID=$!

echo "$LARAVEL_PID" > "$PID_DIR/laravel.pid"

sleep 2

if ! kill -0 "$LARAVEL_PID" 2>/dev/null; then
    echo "ERROR: Laravel gagal dijalankan."
    echo "Cek:"
    echo "cat $LOG_DIR/laravel-serve.log"
    rm -f "$PID_DIR/laravel.pid"
    exit 1
fi

echo "Laravel started. PID: $LARAVEL_PID"

# ------------------------------------------
# Start Laravel Scheduler
# ------------------------------------------

echo ""
echo "Starting Laravel Scheduler..."

nohup php8.3 artisan schedule:work \
    > "$LOG_DIR/laravel-schedule.log" 2>&1 &

SCHEDULER_PID=$!

echo "$SCHEDULER_PID" > "$PID_DIR/scheduler.pid"

echo "Scheduler started. PID: $SCHEDULER_PID"

# ------------------------------------------
# Start ngrok
# ------------------------------------------

echo ""
echo "Starting ngrok..."

if [ -f "$PID_DIR/ngrok.pid" ]; then

    OLD_NGROK_PID=$(cat "$PID_DIR/ngrok.pid")

    if kill -0 "$OLD_NGROK_PID" 2>/dev/null; then
        echo "ngrok masih berjalan. PID: $OLD_NGROK_PID"
    else
        rm -f "$PID_DIR/ngrok.pid"
    fi
fi

if [ ! -f "$PID_DIR/ngrok.pid" ]; then

    nohup ngrok http "$LARAVEL_PORT" \
        --url "https://$NGROK_DOMAIN" \
        > "$LOG_DIR/ngrok.log" 2>&1 &

    NGROK_PID=$!

    echo "$NGROK_PID" > "$PID_DIR/ngrok.pid"

    sleep 3

    if kill -0 "$NGROK_PID" 2>/dev/null; then
        echo "ngrok started. PID: $NGROK_PID"
    else
        echo "ERROR: ngrok gagal dijalankan."
        echo "Cek:"
        echo "cat $LOG_DIR/ngrok.log"
        rm -f "$PID_DIR/ngrok.pid"
    fi

fi

# ------------------------------------------
# Finish
# ------------------------------------------

echo ""
echo "=========================================="
echo "ULD APPLICATION RUNNING"
echo "=========================================="
echo ""
echo "Laravel:"
echo "  http://127.0.0.1:$LARAVEL_PORT"
echo ""
echo "Public:"
echo "  https://$NGROK_DOMAIN"
echo ""
echo "Laravel PID  : $LARAVEL_PID"
echo "Scheduler PID: $SCHEDULER_PID"

if [ -f "$PID_DIR/ngrok.pid" ]; then
    echo "ngrok PID    : $(cat "$PID_DIR/ngrok.pid")"
fi

echo ""
echo "Vite:"
echo "  Production build only"
echo "  public/build"
echo ""
echo "Logs:"
echo "  Laravel   : $LOG_DIR/laravel-serve.log"
echo "  Scheduler : $LOG_DIR/laravel-schedule.log"
echo "  ngrok     : $LOG_DIR/ngrok.log"
echo ""
echo "=========================================="