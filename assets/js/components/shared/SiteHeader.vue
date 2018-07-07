<template>
  <header>
    <nav id="mainNav">
      <div class="container">
        <div class="row">
          <ul>
            <li>
              <a :href="common.routes.index">Accueil</a>
            </li>
            <li>
              <a href="#">Règles du jeu</a>
            </li>
            <li>
              <a href="#">Codex</a>
            </li>
            <li>
              <a href="#">Support</a>
            </li>
            <!-- {% if is_granted('ROLE_ADMIN') %} -->
            <li>
              <a href="#">Administration</a>
            </li>
            <!-- {% endif %} -->
          </ul>

          <ul>
            <li v-if="common.isAuthenticated">
              <a :href="common.routes.logout">Déconnexion</a>
            </li>
            <template v-else>
              <li class="login">
                <a :href="common.routes.login">Connexion</a>
              </li>
              <li class="register">
                <a :href="common.routes.register">Inscription</a>
              </li>
            </template>
            <!-- {% endif %} -->
          </ul>

        </div>
        <!-- /.div row -->

      </div>
      <!-- /.div container -->

    </nav>

    <nav id="secondNav">

      <div class="container">

        <div class="row">
          <ul>
            <!-- {% if is_granted('IS_AUTHENTICATED_REMEMBERED') %} -->
            <li>Bienvenue,
              <div class="dropdownSystem">
                <!-- <strong>{{ app.user.username }}</strong> -->
                <span class="glyphicon glyphicon-triangle-bottom"></span>

                <ol class="user-menu dropdown-items">
                  <li>
                    <strong>Leslye Raltir</strong>Maître Jedi</li>
                  <li>
                    <a href="#">Profil utilisateur</a>
                  </li>
                  <li>
                    <a href="#">Feuille de personnage</a>
                  </li>
                  <!-- {% if is_granted('ROLE_ADMIN') %} -->
                  <li>
                    <!-- <a href="{{ path('dashboard') }}">Asservir la galaxie</a> -->
                  </li>
                  <!-- {% endif %} -->
                </ol>
              </div>
            </li>
            <!-- {% endif %} -->
          </ul>
          <!-- {% if app.request.attributes.get('_route') != 'index' %} -->
          <ul class="arianePath">
            <li>
              <!-- <a href="{{ path('index') }}">Index</a> -->
            </li>
            <!-- {% if app.request.attributes.get('_route') == 'viewforum' or app.request.attributes.get('_route') == 'viewtopic' or app.request.attributes.get('_route') -->
            <!-- == 'editpost' %} -->
            <span class="glyphicon glyphicon-chevron-right"></span>
            <li>
              <!-- <a href="{{ path('viewforum', {'forumId': forumData.id, 'cleanName': forumData.cleanName}) }}">{{ forumData.name }}</a> -->
            </li>
            <!-- {% endif %} {% if app.request.attributes.get('_route') == 'viewtopic' or app.request.attributes.get('_route') == 'editpost' -->
            <!-- %} -->
            <span class="glyphicon glyphicon-chevron-right"></span>
            <li>
              <!-- <a href="{{ path('viewtopic', {'topicId': topicData.id, 'cleanTitle': topicData.cleanTitle}) }}">{{ topicData.title }}</a> -->
            </li>
            <!-- {% endif %} {% if app.request.attributes.get('_route') == 'viewprofile' or app.request.attributes.get('_route') == 'editprofile' -->
            <!-- %} -->
            <span class="glyphicon glyphicon-chevron-right"></span>
            <li>
              <!-- <a href="{{ path('viewprofile', {'userId': userData.id}) }}">{{ pageTitle }}</a> -->
            </li>
            <!-- {% endif %} -->
          </ul>
          <!-- {% endif %} -->
        </div>
        <!-- /.div row -->

      </div>
      <!-- /.div container -->

    </nav>

    <div class="logo">
      <a :href="common.routes.index">
        <img src="../../../img/logo.png" alt="Logo" />
      </a>
    </div>

  </header>
</template>

<script>
export default {
  name: 'SiteHeader',
  inherit: true,
  data () {
    return {
      msg: 'Welcome to Your Vue.js App',      
      common: this.$parent.common
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
/* h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
} */
</style>