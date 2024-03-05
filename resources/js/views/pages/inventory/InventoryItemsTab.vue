<script setup>
const refInputEl = ref()
const refInputE2 = ref()
</script>

<script>
import DataService from "../../../services/DataService"
import Editor from '@tinymce/tinymce-vue'
import Dropzone from './Dropzone.vue'

export default {
  name: "Services",
  components: { 
  },
  data() {
    return {
      itemData: [],
      currentData: {
        id: "",
        name: "",
        description: "",
        quantity: "0",
        price: "0.00",
      },
      currentIndex: -1,
      search: "",
      nameError: "",
      descriptionError: "",
      quantityError: "",
      priceError: "",
    }
  },
  mounted() {
    this.retrieveData()
  },
  methods: {
    retrieveData() {
      DataService.getAll('inventory-item/0')
        .then(response => {
          this.itemData = response.data
        })
        .catch(e => {
          console.log(e)
        })
    },
    saveData(selId) {
      var data = {
        id: this.currentData.id,
        name: this.currentData.name,
        description: this.currentData.description,
        quantity: this.currentData.quantity,
        price: this.currentData.price,
      }

      DataService.create('inventory-item', data)
        .then(response => {
          this.retrieveData()
          this.currentData.id = ""
          this.currentData.name = ""
          this.currentData.description = ""
          this.currentData.quantity = "0"
          this.currentData.price = "0.00"
        })
        .catch(error => {
          if (error.response && error.response.status === 422) {
            // error handling
            const errors = error.response.data.errors;
            this.nameError = errors.name ? errors.name.join(", ") : "";
            this.descriptionError = errors.description ? errors.description.join(", ") : "";
            this.quantityError = errors.quantity ? errors.quantity.join(", ") : "";
            this.priceError = errors.price ? errors.price.join(", ") : "";
          } else {
            console.error("Error:", error);
            alert("An error occurred while saving the data. Please try again later.");
          }
        });
    },
    /*saveData(selId) {
      var data = {
        id: this.currentData.id,
        name: this.currentData.name,
        description: this.currentData.description,
        quantity: this.currentData.quantity,
        price: this.currentData.price,
      }
      DataService.create('inventory-item', data)
        .then(response => {
          this.retrieveData()
          this.currentData. id= ""
          this.currentData.name=""
          this.currentData.description= ""
          this.currentData.quantity= "0"
          this.currentData.price= "0.00"
        })
        .catch(e => {
          console.log(e)
        })
    },*/
    resetForm(){
      this.currentData. id= ""
      this.currentData.name=""
      this.currentData.description= ""
      this.currentData.quantity= "0"
      this.currentData.price= "0.00"
    },
    refreshList() {
      this.retrieveData()
      this.currentData = null
      this.currentIndex = -1
    },
    setActiveRow(data, index) {
      this.currentData = data
      this.currentIndex = data.id
    },
    removeAll() {
      DataService.deleteAll('inventory-item')
        .then(response => {      
          this.retrieveData()
        })
        .catch(e => {
          console.log(e)
        })
    },
    searchData() {
      DataService.findByParameter('inventory-item/0/', this.search)
        .then(response => {
          this.itemData = response.data
        })
        .catch(e => {
          console.log(e)
        })
    },
    deleteRow(id) {
      DataService.delete('inventory-item', id)
        .then(response => {
          this.retrieveData()
        })
        .catch(e => {
          console.log(e)
        })
    },
  },
}
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Add / Edit an Inventory item">
        <VDivider />
         <VCardText>
          <VForm class="mt-6" :class="{ 'has-error': hasError }">
            <VRow>
              <VCol
                md="6"
                cols="6"
              >
                <VTextField
                  v-model="currentData.id"
                  type="hidden"
                />
                <VTextField
                  v-model="currentData.name"
                  placeholder=""
                  label="Name"
                  :error-messages="nameError"
                  :error="nameError !== ''"
                />
              </VCol>
            </VRow>
            <VRow>
              <VCol
                cols="6"
                md="6"
              >
                <VTextField
                  v-model="currentData.description"
                  placeholder=""
                  label="Description"
                  :error-messages="descriptionError"
                  :error="descriptionError !== ''"
                />
              </VCol>
            </VRow>

            <VRow>
              <VCol
                cols="6"
                md="6"
              >
                <VTextField
                  v-model="currentData.quantity"
                  placeholder=""
                  label="Quantity"
                  :error-messages="quantityError"
                  :error="quantityError !== ''"
                />
              </VCol>
            </VRow>

            <VRow>
              <VCol
                cols="6"
                md="6"
              >
                <VTextField
                  v-model="currentData.price"
                  placeholder=""
                  label="Price"
                  :error-messages="priceError"
                  :error="priceError !== ''"
                />
              </VCol>
            </VRow>
            <VRow>
              <VCol
                cols="12"
                class="d-flex flex-wrap gap-4"
              >
                <VBtn @click="saveData(currentData.id)">
                  Save changes
                </VBtn>

                <VBtn
                  color="secondary"
                  variant="tonal"
                  type="reset"
                  @click="resetForm"
                >
                  Reset
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
 

    <VCol cols="12">
      <VCard title="Inventory items">
        <VCardText>
          <div class="list row">
            <VCol cols="5">
              <VTextField
                v-model="search"
                class="form-control"
                placeholder="Search an item"
                @input="searchData"
              />
            </VCol>
            <div class="col-md-6">
              <VTable class="text-no-wrap">
                <thead>
                  <tr>
                    <th scope="col">
                      Name
                    </th>
                    <th scope="col">
                      Description
                    </th>
                    <th scope="col">
                      Quantity
                    </th>
                    <th scope="col">
                      Price
                    </th>
                    <th scope="col" />
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(data, index) in itemData"
                    :key="index"
                    :class="{ 'active-row' : index === currentIndex }"
                    @click="setActiveRow(data, index)"
                  >
                    <td>
                      {{ data.name }}
                    </td>
                    <td>
                      {{ data.description }}
                    </td>
                    <td>
                      {{ data.quantity }}
                    </td>
                    <td>
                      {{ data.price }}
                    </td>
                    <td>
                      <button
                        class="badge badge-danger"
                        @click="deleteRow(data.id )"
                      >
                        Delete
                      </button>
                    </td>
                  </tr>
                </tbody>
              </VTable>
              <hr><br>
              <VBtn
                color="primary"
                @click="removeAll"
              >
                Remove All
              </VBtn>
            </div>
          </div>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>

<style scoped>.has-error .v-messages__message {
  color: red;
}

.has-error .v-input__control {
  border-color: red;
}
</style>
