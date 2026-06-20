# Extraction RDFa du CV

Objectif : montrer qu'un agent peut extraire des triplets RDF depuis le CV HTML.

## Fichiers utiles

- `cv-rdfa.html` : page CV annotée en RDFa.
- `rdfa/hasina-cv.ttl` : sérialisation Turtle attendue.
- `rdfa/cv-sparql.rq` : requêtes SPARQL pour interroger les données.

## Attributs RDFa utilisés

- `prefix` : déclaration des vocabulaires `schema`, `foaf`, `dc`, `dcterms`, `org`, `xsd`.
- `about` : URI du sujet RDF.
- `typeof` : type de ressource, par exemple `schema:Person`.
- `property` : propriété littérale, par exemple `schema:name`.
- `rel` et `resource` : relation vers une autre ressource, par exemple une organisation.

## Vérification possible

1. Ouvrir `cv-rdfa.html` dans un navigateur pour vérifier la lisibilité humaine.
2. Copier le code HTML dans un extracteur RDFa compatible.
3. Comparer les triplets obtenus avec `rdfa/hasina-cv.ttl`.
4. Charger le Turtle dans Corese et lancer `rdfa/cv-sparql.rq`.

Exemple de triplet attendu :

```turtle
<https://hamkitsi.github.io/#hasina> schema:knowsAbout "RDFa" .
```
