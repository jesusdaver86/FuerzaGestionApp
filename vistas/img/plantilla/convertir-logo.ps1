Add-Type -AssemblyName System.Drawing

# Configuración
$logoPath = "C:\UwAmp\www\fuente\vistas\img\plantilla\logo-blanco-bloque.png"
$outputPath = "C:\UwAmp\www\fuente\vistas\img\plantilla\Nueva carpeta\icon-512x512.png"
$squareSize = 512

# Cargar imagen
$logo = [System.Drawing.Image]::FromFile($logoPath)

# Crear bitmap transparente
$bitmap = New-Object System.Drawing.Bitmap($squareSize, $squareSize, [System.Drawing.Imaging.PixelFormat]::Format32bppArgb)
$graphics = [System.Drawing.Graphics]::FromImage($bitmap)
$graphics.Clear([System.Drawing.Color]::Transparent)

# Escalar proporcionalmente
$scale = [Math]::Min($squareSize / $logo.Width, $squareSize / $logo.Height)
$newWidth = $logo.Width * $scale
$newHeight = $logo.Height * $scale

# Centrar y dibujar
$xPos = [int](($squareSize - $newWidth) / 2)
$yPos = [int](($squareSize - $newHeight) / 2)
$graphics.DrawImage($logo, $xPos, $yPos, $newWidth, $newHeight)

# Guardar
$bitmap.Save($outputPath, [System.Drawing.Imaging.ImageFormat]::Png)

# Liberar recursos
$graphics.Dispose()
$bitmap.Dispose()
$logo.Dispose()

Write-Output "¡Icono con fondo transparente generado en $outputPath!"