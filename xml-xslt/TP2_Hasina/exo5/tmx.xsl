<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" encoding="UTF-8" indent="yes"/>

  <xsl:template match="/">
    <html lang="fr">
      <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Exercice 5 - TMX 32014R0231</title>
        <link rel="stylesheet" type="text/css" href="tmx.css" media="screen"/>
      </head>
      <body>
        <main>
          <header class="entete">
            <p class="sur-titre">Exercice 5 — visualisation XSLT d'un fichier TMX</p>
            <h1>
              <xsl:value-of select="/tmx/body/tu[1]/tuv[@lang='FR-FR']/seg"/>
            </h1>
            <p class="intro">
              Le document est affiché sous forme de tableau d'alignement : une ligne par unité de traduction,
              avec les segments anglais, français et allemand côte à côte.
            </p>
          </header>

          <section class="infos">
            <h2>Informations du fichier</h2>
            <dl>
              <dt>Document</dt>
              <dd><xsl:value-of select="/tmx/body/tu[1]/prop[@type='Txt::Doc. No.']"/></dd>

              <dt>Version TMX</dt>
              <dd><xsl:value-of select="/tmx/@version"/></dd>

              <dt>Outil de création</dt>
              <dd><xsl:value-of select="/tmx/header/@creationtool"/></dd>

              <dt>Langue source</dt>
              <dd><xsl:value-of select="/tmx/header/@srclang"/></dd>

              <dt>Nombre d'unités de traduction</dt>
              <dd><xsl:value-of select="count(/tmx/body/tu)"/></dd>

              <dt>Langues indiquées dans l'en-tête</dt>
              <dd>
                <xsl:for-each select="/tmx/header/langues/langue">
                  <span class="badge"><xsl:value-of select="."/></span>
                </xsl:for-each>
              </dd>
            </dl>
          </section>

          <section class="contenu">
            <h2>Alignement des traductions</h2>
            <table class="tmx">
              <thead>
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Anglais <span>EN-GB</span></th>
                  <th scope="col">Français <span>FR-FR</span></th>
                  <th scope="col">Allemand <span>DE-DE</span></th>
                </tr>
              </thead>
              <tbody>
                <xsl:for-each select="/tmx/body/tu">
                  <tr>
                    <td class="numero"><xsl:value-of select="position()"/></td>
                    <td lang="en">
                      <xsl:choose>
                        <xsl:when test="tuv[@lang='EN-GB']/seg">
                          <xsl:value-of select="tuv[@lang='EN-GB']/seg"/>
                        </xsl:when>
                        <xsl:otherwise><span class="manquant">—</span></xsl:otherwise>
                      </xsl:choose>
                    </td>
                    <td lang="fr">
                      <xsl:choose>
                        <xsl:when test="tuv[@lang='FR-FR']/seg">
                          <xsl:value-of select="tuv[@lang='FR-FR']/seg"/>
                        </xsl:when>
                        <xsl:otherwise><span class="manquant">—</span></xsl:otherwise>
                      </xsl:choose>
                    </td>
                    <td lang="de">
                      <xsl:choose>
                        <xsl:when test="tuv[@lang='DE-DE']/seg">
                          <xsl:value-of select="tuv[@lang='DE-DE']/seg"/>
                        </xsl:when>
                        <xsl:otherwise><span class="manquant">—</span></xsl:otherwise>
                      </xsl:choose>
                    </td>
                  </tr>
                </xsl:for-each>
              </tbody>
            </table>
          </section>
        </main>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
