<template>
    <v-form>
        <v-text-field
                autofocus
                v-model="name"
                label="Nom"
                hint="El nom de l'etiqueta..."
                placeholder="Nom de l'etiqueta"
                :error-messages="nameErrors"
                @input="$v.name.$touch()"
                @blur="$v.name.$touch()"
        ></v-text-field>

        <v-text-field
                autofocus
                v-model="color"
                label="Nom"
                hint="El color de l'etiqueta... #1992D4, yellow o rgb(97, 41, 160)"
                placeholder="Color de l'etiqueta"
                :error-messages="colorErrors"
                @input="$v.color.$touch()"
                @blur="$v.color.$touch()"
        ></v-text-field>

        <v-textarea v-model="description" label="Descripció" hint="Escriu la descripció de l'etiqueta..."
                    :error-messages="descriptionErrors"
                    @input="$v.description.$touch()"
                    @blur="$v.description.$touch()"></v-textarea>

        <v-flex class="text-xs-right">
        <v-btn
          class="grey--text text--lighten-2"
          flat
          @click="$emit('close')"
          aria-label="Cancel·lar"
        >Cancel·lar</v-btn>
        <v-btn
          flat
          color="primary"
          @click="add"
          :disabled="loading || $v.$invalid"
          :loading="loading"
          aria-label="Actualitza"
        >Crea</v-btn>
      </v-flex>
    </v-form>
</template>

<script>
import { validationMixin } from 'vuelidate'
import { required } from 'vuelidate/lib/validators'
export default {
  name: 'TagsForm',
  mixins: [validationMixin],
  validations: {
    name: { required },
    color: { required },
    description: { required }
  },
  data () {
    return {
      name: '',
      color: '',
      description: '',
      loading: false
    }
  },
  computed: {
    nameErrors () {
      const errors = []
      if (!this.$v.name.$dirty) return errors
      !this.$v.name.required && errors.push('El camp name és obligatori.')
      return errors
    },
    descriptionErrors () {
      const errors = []
      if (!this.$v.description.$dirty) return errors
      !this.$v.description.required && errors.push('El camp description és obligatori.')
      return errors
    },
    colorErrors () {
      const errors = []
      if (!this.$v.color.$dirty) return errors
      !this.$v.color.required && errors.push('El camp color és obligatori.')
      return errors
    }
  },
  methods: {
    reset () {
      this.name = ''
      this.description = ''
      this.color = ''
    },
    add () {
      this.loading = true
      let tag = {
        'name': this.name,
        'color': this.color,
        'description': this.description
      }
      window.axios.post('/api/v1/tags', tag).then(response => {
        this.$snackbar.showMessage('Etiqueta creada correctament')
        this.reset()
        this.$emit('created', response.data)
        this.loading = false
        this.$emit('close')
      }).catch(error => {
        this.$snackbar.showError(error.message)
        this.loading = false
      })
    }
  }
}
</script>