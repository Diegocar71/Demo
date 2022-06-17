@For /F "tokens=1,2,3 delims=/ " %%A in ('Date /t') do @(
Set Day=%%A
Set Month=%%B
Set Year=%%C
Set FECHA=%%C%%B%%A

)

@For /F "tokens=1,2,3 delims=: " %%A in ('Time /t') do @(
Set Hour=%%A
Set Min=%%B
Set HORA=%%A%%B
)

Set SISTEMA=demo
set /p mensajecommit=
Set MENSAJE=Desarrollando_%mensajecommit%

git status

git add .

git commit -m %SISTEMA%_%FECHA%%HORA%-%MENSAJE%

git push
pause
exit
