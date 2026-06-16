<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:output method="html" encoding="UTF-8"/>

  <xsl:template match="/">
    <html>
      <head>
        <title>
          Liste de <xsl:value-of select="count(enseignants/enseignant)"/> enseignants
        </title>

        <style type="text/css">
          body {
            background-color: #ffffaa;
            font-family: Arial, sans-serif;
          }

          div.cadre {
            border: 4px solid black;
            width: 720px;
            margin: 40px;
            padding: 50px 40px;
          }

          h1 {
            font-family: serif;
            font-size: 36px;
            margin-top: 0;
            margin-bottom: 20px;
          }

          table {
            border-collapse: collapse;
            font-size: 24px;
          }

          td {
            padding: 8px 14px;
            border: 3px solid #ffffaa;
            text-align: center;
          }

          tr.homme {
            background-color: #30a9c7;
          }

          tr.femme {
            background-color: #ee99e8;
          }

          .description {
            text-align: left;
          }

          .sans-equipe {
            font-style: italic;
          }
        </style>
      </head>

      <body>
        <div class="cadre">

          <h1>
            Liste de <xsl:value-of select="count(enseignants/enseignant)"/> enseignants
          </h1>

          <table>
            <tr>
              <th>Prénom</th>
              <th>Nom</th>
              <th colspan="3">Description</th>
            </tr>

            <xsl:for-each select="enseignants/enseignant">
              <tr>
                <xsl:attribute name="class">
                  <xsl:choose>
                    <xsl:when test="@sexe='f'">femme</xsl:when>
                    <xsl:otherwise>homme</xsl:otherwise>
                  </xsl:choose>
                </xsl:attribute>

                <td>
                  <xsl:value-of select="prenom"/>
                </td>

                <td>
                  <xsl:value-of select="nom"/>
                </td>

                <td class="description">
                  <xsl:apply-templates select="note"/>
                </td>

                <td>
                  <xsl:value-of select="labo"/>
                </td>

                <td>
                  <xsl:choose>
                    <xsl:when test="equipe">
                      <xsl:value-of select="equipe"/>
                    </xsl:when>
                    <xsl:otherwise>
                      <span class="sans-equipe">(pas d'équipe)</span>
                    </xsl:otherwise>
                  </xsl:choose>
                </td>

              </tr>
            </xsl:for-each>
          </table>

        </div>
      </body>
    </html>
  </xsl:template>

  <!-- Pour afficher correctement le contenu de note -->
  <xsl:template match="note">
    <xsl:apply-templates/>
  </xsl:template>

  <!-- Pour conserver le gras dans la note -->
  <xsl:template match="b">
    <b>
      <xsl:apply-templates/>
    </b>
  </xsl:template>

</xsl:stylesheet>