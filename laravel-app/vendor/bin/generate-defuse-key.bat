@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/generate-defuse-key
SET COMPOSER_BIN_DIR=%~dp0
php "%BIN_TARGET%" %*
