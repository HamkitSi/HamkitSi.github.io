<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" encoding="UTF-8" indent="yes"/>
  <xsl:template match="/">
    <html lang="fr">
      <head>
        <meta charset="UTF-8"/>
        <title>La Compagnie des glaces — XML + XSLT</title>
        <link rel="stylesheet" href="../assets/css/style.css"/>
      </head>
      <body class="subpage">
        <main class="page-shell">
          <p><a href="../index.html#compagnie">← Retour au portfolio</a></p>
          <h1>La Compagnie des glaces</h1>
          <p class="lead">Cette page est générée depuis le fichier XML avec une feuille XSLT.</p>
          <section class="album-grid">
            <xsl:for-each select="catalogue/album">
              <article class="album-card">
                <img src="images/placeholder-cover.svg" alt="Couverture symbolique"/>
                <div>
                  <p class="pill">Tome <xsl:value-of select="@numero"/></p>
                  <h2><xsl:value-of select="nom"/></h2>
                  <p><xsl:value-of select="resume"/></p>
                  <p><a href="{lien}">Fiche Booknode</a></p>
                  <ul>
                    <xsl:for-each select="titres/titre">
                      <li><xsl:value-of select="."/></li>
                    </xsl:for-each>
                  </ul>
                </div>
              </article>
            </xsl:for-each>
          </section>
        </main>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
