<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:media="http://search.yahoo.com/mrss/">

  <xsl:output method="html" encoding="UTF-8" indent="yes"/>

  <xsl:template match="/">
    <html lang="fr">
      <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title><xsl:value-of select="/rss/channel/title"/></title>
        <link rel="stylesheet" type="text/css" href="une.css" media="screen"/>
      </head>
      <body>
        <header class="site-header">
          <p class="label">Flux RSS</p>
          <h1><xsl:value-of select="/rss/channel/title"/></h1>
          <p class="intro"><xsl:value-of select="/rss/channel/description"/></p>
          <p class="meta">
            Dernière mise à jour du flux :
            <xsl:value-of select="/rss/channel/pubDate"/>
          </p>
        </header>

        <main class="articles">
          <xsl:for-each select="/rss/channel/item">
            <article class="article-card">
              <xsl:if test="media:content/@url">
                <a class="image-link" href="{link}">
                  <img src="{media:content/@url}" alt="{media:content/media:description}"/>
                </a>
              </xsl:if>

              <section class="article-text">
                <p class="date"><xsl:value-of select="pubDate"/></p>
                <h2>
                  <a href="{link}">
                    <xsl:value-of select="title"/>
                  </a>
                </h2>
                <p class="description"><xsl:value-of select="description"/></p>

                <xsl:if test="media:content/media:credit">
                  <p class="credit">
                    Crédit image : <xsl:value-of select="media:content/media:credit"/>
                  </p>
                </xsl:if>

                <p><a class="read-more" href="{link}">Lire l’article</a></p>
              </section>
            </article>
          </xsl:for-each>
        </main>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
