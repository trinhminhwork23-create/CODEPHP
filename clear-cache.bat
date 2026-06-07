@echo off
REM ══════════════════════════════════════════════════════════════════════════════
REM PRE-COMMIT CACHE PURGE SCRIPT - Sapa Jade Hill Resort & Spa
REM ══════════════════════════════════════════════════════════════════════════════

echo [1/5] Clearing configuration cache...
C:\xampp\php\php artisan config:clear

echo [2/5] Clearing route cache...
C:\xampp\php\php artisan route:clear

echo [3/5] Clearing view cache...
C:\xampp\php\php artisan view:clear

echo [4/5] Clearing application cache...
C:\xampp\php\php artisan cache:clear

echo [5/5] Optimizing autoloader...
C:\xampp\php\php artisan optimize:clear

echo.
echo ✓ All caches cleared successfully
echo ✓ Ready for git commit
