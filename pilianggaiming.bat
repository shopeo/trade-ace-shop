@echo off
setlocal enabledelayedexpansion
 
:: 设置原字符串和替换字符串
set "search_for=nasa"
set "replace_with=tradeace"
 
:: 对当前文件夹及子文件夹中的文件名进行处理
for /R %%F in (*%search_for%*) do (
    set "filename=%%~nxF"
    set "newname=!filename:%search_for%=%replace_with%!"
    if not "!filename!"=="!newname!" (
        move "%%F" "%%~dpF!newname!"
    )
)
 
endlocal