@echo off

:: Comprueba si se pasó el nombre del modelo como parámetro
if "%1"=="" (
    echo Debes proporcionar el nombre del modelo al ejecutar el script.
    echo Ejemplo: crear_modelo.bat NombreModelo
    exit /b
)


:: Ejecuta el comando para crear el modelo, controlador API y migración
php artisan make:model %1 
php artisan make:controller API\%1Controller --api 
php artisan make:resource %1Resource

echo  %1 OK.
pause
