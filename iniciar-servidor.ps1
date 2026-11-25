$ErrorActionPreference = 'Stop'

if ([string]::IsNullOrWhiteSpace($env:ADMIN_EMAIL)) {
    $env:ADMIN_EMAIL = 'admin@limonedoro.com'
}

if ([string]::IsNullOrWhiteSpace($env:ADMIN_PASSWORD)) {
    $env:ADMIN_PASSWORD = 'admin123'
}

$apache = 'C:\xampp\apache\bin\httpd.exe'
$configuracaoApache = 'C:\xampp\apache\conf\httpd.conf'

if (-not (Test-Path $apache) -or -not (Test-Path $configuracaoApache)) {
    throw 'Apache do XAMPP não foi encontrado em C:\xampp.'
}

& $apache -t -f $configuracaoApache
if ($LASTEXITCODE -ne 0) {
    throw 'A configuração do Apache tem erros. Corrija-os antes de iniciar o servidor.'
}

Write-Host 'Servidor disponível em http://localhost/projeto-inicial/login.html'
Write-Host 'Mantenha esta janela aberta. Pressione Ctrl+C para encerrar.'

try {
    & $apache -f $configuracaoApache -D FOREGROUND
}
finally {
    Remove-Item Env:\ADMIN_EMAIL -ErrorAction SilentlyContinue
    Remove-Item Env:\ADMIN_PASSWORD -ErrorAction SilentlyContinue
}
