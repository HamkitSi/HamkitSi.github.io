# Portfolio Web sémantique : Hasina RAKOTOARISON

Ce dossier contient un portfolio complet, simple, ludique et pédagogique aux couleurs de la forêt : blanc, beige, vert et marron.

## Dépôt sur GitHub Pages

1. Dézipper l'archive.
2. Copier le contenu du dossier `portfolio-hasina-rakotoarison/` à la racine du dépôt `hamkitsi.github.io`.
3. Vérifier que `index.html` est bien à la racine.
4. Pousser sur GitHub.
5. Ouvrir : https://hamkitsi.github.io/

La version GitHub Pages utilise les pages statiques :

- `index.html` : français ;
- `index.en.html` : anglais ;
- `index.ja.html` : japonais.

## Version PHP pour respecter la consigne serveur

Le fichier `index.php` implémente la sélection de langue dans cet ordre : GET, POST, session, navigateur, langue par défaut. Il lit le contenu dans `data/contenu.xml`.

À utiliser sur un serveur PHP :

```bash
php -S localhost:8000
```

Puis ouvrir : `http://localhost:8000/index.php?lang=fr`.

## Fichiers importants

- `data/contenu.xml` : source multilingue des textes.
- `tp1/bon.xml`, `tp1/bon2.xml`, `tp1/bon3.xml`, `tp1/bon4.xml` : fichiers XML corrigés.
- `tp1/arbres.dtd` : DTD unique.
- `tp1/compagnie.xml` : XML avec XSLT.
- `tp1/compagnie-css.xml` : XML avec CSS.
- `tp1/requetes_xpath_reponses.txt` : réponses XPath.
- `tp1/svg/` : exercices SVG.
- `xml-xslt/TP2_Hasina/` : fichiers du TP XML/XSD/XSLT.
- `rdf-corese/glaces.ttl` et `rdf-corese/requetes.sparql` : RDF et requêtes Corese.

## Résultats XPath intégrés

- Albums : 16
- Titres : 63
- Titres contenant « glace » : 7
- Albums reliés à « banquise » : 6
- Albums contenant un mot du domaine du froid : 16

## Tests conseillés avant rendu

- https://validator.w3.org/
- https://jigsaw.w3.org/css-validator/
- `xmllint --valid --noout tp1/bon.xml`
- `xmllint --schema data/contenu.xsd data/contenu.xml`


## Mise à jour RDFa / CV

La version mise à jour ajoute :

- `cv-rdfa.html`, `cv-rdfa.en.html`, `cv-rdfa.ja.html` : CV multilingue annoté en RDFa.
- `rdfa/hasina-cv.ttl` : triplets Turtle attendus.
- `rdfa/cv-sparql.rq` : requêtes SPARQL sur le CV.
- `rdfa/extraction.md` : méthode pour expliquer l'extraction RDFa par un agent.
- `docs/CR_TP3_RDF_SPARQL_Corese.pdf`, `docs/CR_TP4_XMLSchema_XSLT_Unicode.pdf`, `docs/CR_TP5_RDFa_WebSemantique.pdf` : comptes rendus des autres TPs.

RDFa signifie **Resource Description Framework in Attributes** : les triplets RDF sont écrits directement dans les attributs du HTML (`about`, `typeof`, `property`, `rel`, `resource`).
