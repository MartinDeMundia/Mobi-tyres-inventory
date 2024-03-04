<script setup>
const isPasswordVisible = ref(false)
</script>
<script>
import DataService from "../../../resources/js/services/DataService.js"
export default {
  name: "List",
  data() {
    return {
      formData: {
        email: "",
        password: "",
        remember: false,
      },
    }
  },
  created() {
    localStorage.removeItem('login_token');
  },
  methods: {
    checkToken() {
      const token = localStorage.getItem('login_token');
      if (token) {
        this.$router.push('/');
      }
    },
    verifyUser() {
      DataService.create('login',this.formData)
        .then(response => {
          const token = response.data.token.tokenable_id;
          localStorage.setItem('login_token', token);
          this.$router.push('/')
        })
        .catch(e => {
          console.log(e)
        })
    },
  }
}
</script>


<template>
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <VCard
      class="auth-card pa-4 pt-7"
      max-width="448"
    >
      <VCardItem class="justify-center">
        <template #prepend>
          <div class="d-flex">
            <div
              class="d-flex text-primary"      
            />
          </div>
        </template>
      </VCardItem>
      <VCardText class="pt-2">
        <h5 class="text-h5 mb-1">
          GoodBye 👋🏻
        </h5>
      </VCardText>

      <VCardText>
              <RouterLink
                class="text-primary ms-2"
                to="/login"
              >
                Click to go to login
              </RouterLink>
      </VCardText>
    </VCard>
  </div>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>
