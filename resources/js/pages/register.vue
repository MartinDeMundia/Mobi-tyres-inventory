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
        name: "",
        email: "",
        password: "",
        privacyPolicies: false,
      },
    }
  },
  methods: {
    saveData() {
      DataService.create('register',this.formData)
        .then(response => {
           this.$router.push('login')
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

        <!-- <VCardTitle class="text-2xl font-weight-bold">
          Ravafrica Safaris
        </VCardTitle> -->
      </VCardItem>

      <VCardText class="pt-2">
        <h5 class="text-h5 mb-1">
          Register an account
        </h5>
        <p class="mb-0">
          Make your web app management easy and fun!
        </p>
      </VCardText>

      <VCardText>
        <VForm>
          <VRow>
            <!-- Full name -->
            <VCol cols="12">
              <VTextField
                v-model="formData.name"
                autofocus
                label="Full name"
                placeholder="User"
              />
            </VCol>
            <!-- email -->
            <VCol cols="12">
              <VTextField
                v-model="formData.email"
                label="Email"
                placeholder="info@ravafricasafaris.com"
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
              <div class="d-flex align-center mt-1 mb-4">
                <VCheckbox
                  id="privacy-policy"
                  v-model="formData.privacyPolicies"
                  inline
                />
                <VLabel
                  for="privacy-policy"
                  style="opacity: 1;"
                >
                  <span class="me-1">I agree to</span>
                  <a
                    href="javascript:void(0)"
                    class="text-primary"
                  >privacy policy & terms</a>
                </VLabel>
              </div>

              <VBtn
                block
                type="button"
                @click="saveData()"
              >
                Sign up
              </VBtn>
            </VCol>
            <VCol
              cols="12"
              class="text-center text-base"
            >
              <span>Already have an account?</span>
              <RouterLink
                class="text-primary ms-2"
                to="/login"
              >
                Sign in instead
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
