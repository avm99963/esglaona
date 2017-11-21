# esglaona
Programa en format de pàgina web utilitzat per a organitzar els Campionats d'Esglaonament de Matrius de la FME

## Com instal·lar el programa
Per utilitzar el programa necessitaràs el següent:

* Un servidor (preferentment Apache) amb:
   * PHP (versió 7 recomanada)
   * MySQL (versió 5.5.3 o major recomanada)
* Un compte de [Challonge](http://challonge.com) amb brackets propis que vulguis organitzar.

Un cop compleixis aquests requisits, segueix els següents pasos per instal·lar el programa:

1. Descarrega't aquest repositori (amb un `git clone` o bé descarregan-te un zip des de GitHub i descomprimint-lo) i posa'l a una carpeta del teu servidor.
1. Tot seguit, crea una base de dades a MySQL amb el charset `utf8mb4_general_ci`.
1. Obre el fitxer config.default.php i edita'l per configurar el programa tal com vulguis (trobaràs instruccions a aquell fitxer). Després d'editar-lo, guarda el fitxer com a config.php.
1. Obre al teu navegador preferit la pàgina install.php.
1. Introdueix les dades del primer usuari (administrador) del programa i fes clic a "Install" per acabar d'instal·lar-lo (es generaran les taules a la base de dades).
1. Ja està tot fet! Ara ja pots començar a utilitzar la pàgina web.
