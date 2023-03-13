del /q d:\projects\htdocs\TP\erem2\temp\cache\*
for /d %%x in (d:\projects\htdocs\TP\erem2\temp\cache\*) do @rd /s /q "%%x"

del /q d:\projects\htdocs\TP\erem2\temp\sessions\*
del /q d:\projects\htdocs\TP\erem2\temp\translates\*
del /q d:\projects\htdocs\TP\erem2\data\thumb\*

del /q d:\projects\htdocs\TP\erem2\log\*.html
del /q d:\projects\htdocs\TP\erem2\log\*.log
