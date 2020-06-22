<?xml version="1.0" ?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:esi="https://esi-bru.be/WEBR4">

    <xsl:output method="html"/>

    <xsl:template match="text()"/>

    <xsl:template match="/">
        <html>
            <head>
                <meta charset="UTF-8"/>
                <title>Carnet d'adresses</title>

            </head>
            <body>
                <h1>Relations</h1>

                <xsl:apply-templates/>
            </body>
        </html>
    </xsl:template>

    <xsl:template match="esi:person">
        <h2>
            <xsl:text> </xsl:text>
        </h2>

    </xsl:template>

</xsl:stylesheet>
