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
    this.checkToken();
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
        <template #prepend >
          <div class="d-flex">
            <div
              class="d-flex text-primary"
            />
          </div>
        </template>

       
      </VCardItem>

      <VCardText class="pt-2">
        <h5 class="text-h5 mb-1">
          Secure Login
        </h5>
        <p class="mb-0">
          Please sign-in to your account
        </p>
      </VCardText>

      <VCardText>
        <VForm>
          <VRow>
            <!-- email -->
            <VCol cols="12">
              <VTextField
                v-model="formData.email"
                autofocus
                placeholder="info@ravafricasafaris.com"
                label="Email"
                type="email"
              />
            </VCol>

            <!-- password -->
            <VCol cols="12">
              <VTextField
                v-model="formData.password"
                label="Password"
                placeholder="············"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible"
              />

              <!-- remember me checkbox -->
              <div class="d-flex align-center justify-space-between flex-wrap mt-1 mb-4">
                <VCheckbox
                  v-model="formData.remember"
                  label="Remember me"
                />
                <RouterLink
                  class="text-primary ms-2 mb-1"
                  to="javascript:void(0)"
                >
                  Forgot Password?
                </RouterLink>
              </div>

              <!-- login button -->
              <VBtn
                block
                type="button"
                @click="verifyUser()"
              >
                Login
              </VBtn>
            </VCol>

            <!-- create account -->
            <VCol
              cols="12"
              class="text-center text-base"
            >
              <span>New on our platform?</span>
              <RouterLink
                class="text-primary ms-2"
                to="/register"
              >
                Create an account
              </RouterLink>
            </VCol>                      
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </div>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>
