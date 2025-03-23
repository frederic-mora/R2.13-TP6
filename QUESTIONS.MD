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