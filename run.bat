@echo off
title ZENITH COMMERCE OS - Enterprise Management System
color 0A
cls
echo =====================================================================
echo    ZENITH COMMERCE OS - INTEGRATED LARAVEL SYSTEM (UTS WEB 2)
echo =====================================================================
echo.
echo [1/2] Menyiapkan Sistem & Konfigurasi...
call php artisan config:clear >nul 2>&1
echo [OK] Sistem siap.
echo.
echo [2/2] Menyalakan Web Server Lokal di http://127.0.0.1:8000 ...
echo.
echo Membuka browser otomatis ke http://127.0.0.1:8000 ...
start http://127.0.0.1:8000
echo.
echo Tekan CTRL + C pada jendela ini jika ingin mematikan server.
echo =====================================================================
echo.
call php artisan serve
pause
