$ErrorActionPreference = "Stop";

$packageName = "chromedriver"
$toolsDir    = "$(Split-Path -parent $MyInvocation.MyCommand.Definition)"
$checkSum = "4AA0CB66ACACDF40AADB7AEFA218B1359CDA89275E2E9FB54AF34F7F691BA291"

# The latest version number can be found at http://chromedriver.storage.googleapis.com/LATEST_RELEASE
$chromedriverVersion = "94.0.4606.61"
$url = "https://chromedriver.storage.googleapis.com/$chromedriverVersion/chromedriver_win32.zip"

Install-ChocolateyZipPackage "packageName" -url "$url" -unzipLocation "$toolsDir" -checksumType "sha256" -checksum "$checkSum"
