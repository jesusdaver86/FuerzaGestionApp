🔧 Mejoras clave implementadas:

    Detección robusta de archivos ZIP:

        Busca recursivamente en todos los subdirectorios (**/*.zip)

        Maneja correctamente paths con espacios

    Manejo de errores mejorado:

        Verifica si hay archivos ZIP antes de procesar

        Solo hace commit si hubo cambios reales

        Sistema de salidas (outputs) para control de flujo

    Sistema de recuperación:

        Si el push falla, crea automáticamente un Pull Request

        Usa rebase para evitar conflictos de merge

    Seguridad reforzada:

        Usa el GITHUB_TOKEN integrado

        Configuración explícita de permisos

        Procesamiento seguro de paths

    Información detallada:

        Muestra qué archivos se están procesando

        Outputs claros en cada paso

        Mensajes de commit estandarizados

📌 Instrucciones de uso:

    Copia este workflow a .github/workflows/unzip_files.yml

    Haz push de un archivo ZIP a tu repositorio

    El Action:

        Descomprimirá el ZIP

        Eliminará el archivo original

        Commiteará los nuevos archivos

        Pusheará los cambios a la misma rama

Si hay problemas con el push directo, automáticamente creará un Pull Request con los cambios.
