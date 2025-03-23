## R2.13-TP6 Auto-complétion des menus

Les modifications à réaliser pour ce TP ne concerne que le backoffice. Le client et le serveur sont inchangés.

La mise à jour d'un menu peut être nécessaire pour des corrections mineures. Une simple faute
d'orthographe par exemple. En l'état il est nécessaire dans le backoffice de sélectionner la semaine
et le jour du menu concerné, puis de le re-saisir intégralement. C'est pénible et sujet à faire d'autres
erreurs comme de nouvelles fautes d'orthographe. Pire si on se trompe de jour ou de semaine on va
écraser totalement un menu sans corriger le bon...

Pour éviter ces aléas, on va mettre en place un système d'auto-complétion du formulaire de mise à jour
du backoffice. Dès que l'utilisateur saisit un jour ou une semaine, on va déclencher une requête en lecture
pour la semaine et le jour concerné et si on récupère un menu, on va pré-remplir les champs du formulaire
avec.

Ainsi l'utilisateur est certain du menu qu'il s'apprête à modifier. Et il a juste besoin d'éditer ce qui
doit être modifié ou corrigé.


**Q1. Mise à jour de data/DataMenu.request**
Le backoffice n'avait jusqu'à présent pas besoin de demander un menu au serveur.
Par conséquent il est probable que la fonction DataMenu.request du backoffice ne prenne pas en charge les semaines.
La modification à apporter est la même que pour le DataMenu de l'application client réalisée au TP4.

**Q2. Modification du composant _NewMenuForm_**
Nous allons avoir besoin de recopier des entrées/plats/desserts dans les inputs correspondant du composant
_NewMenuForm_. En javascript écrire dans une élément input revient à modifier sa propriété value.
Par exemple : 
```js
let inputEntree = document.querySelector("input[name=entree]"); 
inputEntree.value = "Salade de tomates";
// Note : le sélecteur css "input[name=entree]" signifie "l'élément input dont la propriété name vaut 'entree'"
```
Aussi, nous allons doter notre composatnt _NewMenuForm_ d'une fonction permettant de recopier tout un menu
dans les inputs correspondant du formulaire. Copiez/coller puis complétez le début de la fonction suivante
dans _NewMenuForm/script.js_ :
```js
/** NewMenuForm.autoFill
 * 
 * Remplit automatiquement les champs d'un formulaire avec les données d'un menu.
 * @param {Object} menu - Un objet représentant un menu.
 * @param {string} menu.entree - Le nom de l'entrée du menu.
 * @param {string} menu.plat - Le nom du plat principal du menu.
 * @param {string} menu.dessert - Le nom du dessert du menu.
 */
NewMenuForm.autoFill = function(menu){
    // etc...
}
```
Notez bien que le paramètre menu est un objet qui respecte le format des menus
retournés par le serveur.

**Q3. Appeler une fonction lorsqu'un champ de formulaire est modifié** 
Vous savez déjà comment faire appeler une fonction par le navigateur lorsque l'utilisateur
clique sur un élément : on utilise la propriété _onclick_ de l'élément pour lui attribuer
la fonction à appeler lorsque l'événement se produit.
A présent nous allons avoir besoin d'appeler une fonction lorsqu'un champ de formulaire
est modifié. Le principe sera le même, c'est juste que l'on va utiliser cette fois la 
propriété _onchange_.
Modifez le template du composant _NewMenuForm_ de sorte à ce qu'il soit possible de le formater avec 2 "handlers": 
- le premier restera celui qui gère l'envoi du formulaire
- le second sera celui qui essaiera d'auto-compléter le formulaire si les champs semaine ou jour changent.
Attention, une fois le template modifié, il faut faudra aussi mettre à jour la fonction
_NewMenuForm.format_ !

**Q4. Mise à jour de l'index.html**
Dans _index.html_ ajoutez une fonction handerSelect au contrôleur C selon le descriptif
ci-dessous :
```js
 /** C.handlerSelect
  * Gère la sélection d'un menu en fonction de la semaine et du jour spécifiés dans le formulaire.
  *
  * Cette fonction récupère les données du formulaire `.addMenu__form` (semaine et jour),
  * envoie une requête pour obtenir le menu correspondant via `DataMenu.request`, 
  * et remplit automatiquement le formulaire avec les données du menu si elles existent.
  * Si aucun menu n'est trouvé, les champs du formulaire sont vidés.
  * Un message est également affiché dans le Log pour indiquer si un menu a été trouvé ou non.
 */
C.handlerSelect = async function(){
    // etc..
```
Pour compléter la fonction, vous pouvez vous inspirer en bonne partie de _C.handlerUpdate_.
Notez que l'on peut lire les valeurs contenues dans un objet FormData.
Au besoin lisez la [documentation](https://developer.mozilla.org/en-US/docs/Web/API/FormData/get).

**Q5. La touche finale**
Il ne vous reste plus qu'à mettre à jour la fonction _C.start_ afin d'initialiser correctement
Le composant _NewMenuForm_ avec le handler _C.handlerUpdate_ et dorénavant le handler _C.handlerSelect_.