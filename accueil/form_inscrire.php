<form id="inscrire" name="inscrire" method="POST" action="verifier_inscrire.php">
    <div class="form-group">
        <label>Nom</label>
        <input type="text" class="form-control" name="nom" id="nom">
    </div>
    <div class="form-group">
        <label>Prénom</label>
        <input type="text" class="form-control" name="prenom" id="prenom">
    </div>
    <div class="form-group">
        <label>Votre addresse email</label>
        <input type="text" class="form-control" name="email" id="email">
    </div>
    <div class="form-group">
        <label>Confirmez votre addresse email</label>
        <input type="text" class="form-control" id="confirm_email">
    </div>
    <div class="form-group">
        <label>L'identifiant</label>
        <input type="text" class="form-control" name="login" id="login">
    </div>
    <div class="form-group">
        <label>Mot de passe</label>
        <input type="password" class="form-control" name="mdp" id="mdp">
    </div>
    <div class="form-group">
        <label>Confirmez votre mot de passe</label>
        <input type="password" class="form-control" id="confirm_mdp">
    </div>
    <div class="form-group">
        <label>Organisation:<i> Université de Techologie de Troyes(UTT) </i></label>
        <input type="hidden" name="organisation" id="organisation" value="UTT">
    </div>
    <div class="form-group">
        <label>Laboratoire</label> 
        <select class="form-control" name="laboratoire" id="laboratoire">
            <option value="CREIDD">CREIDD : Centre de Recherches et d\'Etudes Interdisciplinaires sur le Développement Durable</option>
            <option value="ERA">ERA : Environnement de Réseaux Autonomes</option>
            <option value="GAMMA3">GAMMA3 : Génération Automatique de Maillage et Méthodes Avancées</option>
            <option value="LASMIS">LASMIS : Systèmes Mécaniques et Ingénierie Simultanée</option>
            <option value="LM2S">LM2S : Modélisation et Sûreté des Systèmes</option>
            <option value="LNIO">LNIO : Nanotechnologie et Instrumentation Optique</option>
            <option value="LOSI">LOSI : Optimisation des Systèmes Industriels</option>
            <option value="Tech-CICO">Tech-CICO : Technologies pour la Coopération, l\'Interaction et les COnnaissances dans les collectifs</option> 
        </select>
        <p style="display:none; font-style: italic; color: red"  id="erreur"></p>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="button" value="Submit" name="submit" id="submit" >
        <input class="btn btn-danger" type="reset" value="Reset" id="reset">     
    </div>
</form>