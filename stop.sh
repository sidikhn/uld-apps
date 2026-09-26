#!/bin/bash

# ==========================================
# Laravel + Scheduler + Vite Stop Script
# ==========================================

PROJECT_DIR="$(cd "$(dirname "$0")" && pwd)"
PID_DIR="$PROJECT_DIR/.run"

stop_process() {
    NAME=$1
    PID_FILE=$2

    if [ ! -f "$PID_FILE" ]; then
        echo "$NAME tidak sedang berjalan."
        return
    fi

    PID=$(cat "$PID_FILE")

    if kill -0 "$PID" 2>/dev/null; then
        echo "Stopping $NAME... PID: $PID"
        kill "$PID"

        # Tunggu proses berhenti
        for i in {1..10}; do
            if ! kill -0 "$PID" 2>/dev/null; then
                break
            fi
            sleep 0.5
        done

        # Kalau masih hidup, paksa terminate
        if kill -0 "$PID" 2>/dev/null; then
            echo "$NAME masih berjalan, force stopping..."
            kill -9 "$PID" 2>/dev/null
        fi

        echo "$NAME stopped."
    else
        echo "$NAME sudah tidak berjalan."
    fi

    rm -f "$PID_FILE"
}

echo "=========================================="
echo "Stopping Laravel + Scheduler + Vite"
echo "=========================================="

stop_process "Laravel" "$PID_DIR/laravel.pid"
stop_process "Laravel Scheduler" "$PID_DIR/scheduler.pid"
stop_process "Vite" "$PID_DIR/vite.pid"

echo ""
echo "Laravel + Scheduler + Vite sudah dihentikan."
