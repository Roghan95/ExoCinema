-- a. Informations d’un film (id_film) : titre, année, durée (au format HH:MM) et réalisateur --
SELECT titre, DATE_FORMAT(dateSortie, '%Y'), CONCAT(film.duree DIV 60,'h:', film.duree MOD 60), CONCAT(personne.nom,' ', personne.prenom) AS realisateurFilm
FROM film
INNER JOIN realisateur ON realisateur.id_realisateur = film.id_realisateur
INNER JOIN personne ON personne.id_personne = realisateur.id_personne
WHERE film.id_film = 2;

-- b. Liste des films dont la durée excède 2h15 classés par durée (du + long au + court) --
SELECT titre
FROM film
WHERE duree > 135
ORDER BY duree DESC;

-- c. Liste des films d’un réalisateur (en précisant l’année de sortie) --
SELECT titre, DATE_FORMAT(dateSortie, '%Y')
FROM film 
INNER JOIN realisateur ON realisateur.id_realisateur = film.id_realisateur
INNER JOIN personne ON realisateur.id_personne = personne.id_personne
WHERE realisateur.id_realisateur = 1;

-- d. Nombre de films par genre (classés dans l’ordre décroissant) --
SELECT genre.nom, COUNT(genrer.id_film) AS countFilms
FROM film
INNER JOIN genrer ON genrer.id_film = film.id_film
INNER JOIN genre ON genrer.id_genre = genre.id_genre
GROUP BY genre.id_genre
ORDER BY countFilms DESC;

-- e. Nombre de films par réalisateur (classés dans l’ordre décroissant)--
SELECT personne.nom, personne.prenom, COUNT(film.id_film) AS countFilms
FROM realisateur
INNER JOIN film ON realisateur.id_realisateur = film.id_realisateur
INNER JOIN personne ON personne.id_personne = realisateur.id_personne
GROUP BY realisateur.id_realisateur
ORDER BY countFilms DESC;

-- f. Casting d’un film en particulier (id_film) : nom, prénom des acteurs + sexe -- 
SELECT film.titre, personne.nom, personne.prenom, personne.sexe, role.personnage
FROM jouer
INNER JOIN role ON jouer.id_role = role.id_role
INNER JOIN film ON film.id_film = jouer.id_film
INNER JOIN acteur ON acteur.id_acteur = jouer.id_acteur
INNER JOIN personne ON personne.id_personne = acteur.id_personne
WHERE jouer.id_film = 1

-- g. Films tournés par un acteur en particulier (id_acteur) avec leur rôle et l’année de sortie (du film le plus récent au plus ancien) --
SELECT film.titre, DATE_FORMAT(film.dateSortie, '%Y'), nom, prenom, role.personnage
FROM personne
INNER JOIN acteur ON personne.id_personne = acteur.id_personne
INNER JOIN jouer ON jouer.id_acteur = acteur.id_acteur
INNER JOIN role ON role.id_role = jouer.id_role
INNER JOIN film ON film.id_film = jouer.id_film
WHERE jouer.id_acteur = 2;

-- h. Liste des personnes qui sont à la fois acteurs et réalisateurs --
SELECT nom, prenom 
FROM personne
INNER JOIN realisateur ON realisateur.id_personne = personne.id_personne
INNER JOIN acteur ON acteur.id_personne = personne.id_personne

-- i. Liste des films qui ont moins de 5 ans (classés du plus récent au plus ancien) --
SELECT titre, dateSortie
FROM film
WHERE dateSortie >= DATE_SUB(CURDATE(), INTERVAL 5 YEAR)
ORDER BY dateSortie ASC;

-- j. Nombre d’hommes et de femmes parmi les acteurs -- 
SELECT COUNT(sexe), sexe
FROM personne
GROUP BY sexe

-- k. Liste des acteurs ayant plus de 50 ans (âge révolu et non révolu)
SELECT COUNT(dateNaissance), dateNaissance
FROM personne
WHERE dateNaissance <= DATE_SUB(CURDATE(), INTERVAL 50 YEAR)
ORDER BY dateNaissance DESC;

-- l. Acteurs ayant joué dans 3 films ou plus -- 
SELECT nom, prenom, COUNT(acteur.id_acteur), film.titre
FROM personne
INNER JOIN acteur ON acteur.id_personne = personne.id_personne
INNER JOIN jouer ON jouer.id_acteur = acteur.id_acteur
INNER JOIN film ON film.id_film = jouer.id_film
GROUP BY personne.nom
HAVING COUNT(acteur.id_acteur) >= 3;

-- Liste des acteurs -- 
SELECT id_acteur, CONCAT(personne.nom, ' ', personne.prenom)
FROM acteur 
INNER JOIN personne ON acteur.id_personne = personne.id_personne

-- g. Films tournés par un acteur en particulier (id_acteur) avec leur rôle et l’année de sortie (du film le plus récent au plus ancien) --

SELECT id_acteur, CONCAT(personne.nom, ' ', personne.prenom) AS nomPrenom , personne.sexe, personne.dateNaissance
FROM acteur
INNER JOIN personne ON personne.id_personne = acteur.id_personne


INSERT INTO genre (id_genre, nom)
VALUES (id_genre, Western)
