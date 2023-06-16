<template>
  <div v-if="contentLoaded" class="login d-flex align-center justify-center bg-red" style="min-height: 100vh">
    <v-sheet width="500" relative class="p-relative mx-auto pa-8 rounded-lg">
      <p class="text-h4 text-center pb-8 text-grey-darken-3 font-weight-bold">
        Register
      </p>
      <v-form fast-fail @submit.prevent="signUp">
        <v-text-field prepend-icon="mdi-head" v-model="name" type="text" :rules="nameRules" :error-messages="errors?.name"
          label="Name" hint="At least 2 characters" autocomplete="on" counter @input="errors?.name && delete errors.name">
        </v-text-field>
        <v-text-field prepend-icon="mdi-email" v-model="email" type="email" :rules="emailRules"
          :error-messages="errors?.email" label="Email" autocomplete="on" @input="errors?.email && delete errors.email">
        </v-text-field>
        <v-text-field prepend-icon="mdi-calendar" v-model="education_start" type="date" :rules="dateStartRules"
          :error-messages="errors?.education_start_date" label="Education Start Date" autocomplete="on">
        </v-text-field>
        <v-text-field prepend-icon="mdi-calendar" v-model="education_end" type="date" :rules="dateEndRules"
          :error-messages="errors?.education_end_date" label="Education End Date" autocomplete="on">
        </v-text-field>
        <v-text-field prepend-icon="mdi-lock-outline" v-model="password"
          :rules="[passwordRules.required, passwordRules.min]" :error-messages="errors?.password" type="password"
          name="passwordInput" label="Password" hint="At least 6 characters" autocomplete="off" counter></v-text-field>
        <v-text-field prepend-icon="mdi-lock-outline" v-model="verify" :rules="[passwordRules.required, passwordMatch]"
          :error-messages="errors?.password_confirmation" type="password" name="verifyInput" label="Confirm Password"
          autocomplete="off" counter @click:append="show1 = !show1"></v-text-field>
        <v-checkbox label="I agree to the" v-model="terms" :error-messages="errors?.terms"
          :rules="[termsRules.required]"></v-checkbox>
        <div class=" d-flex justify-center align-center">
          <v-btn type="submit" variant="elevated" class="mt-2 text-white rounded-pill text-h5 w-50 bg-purple-darken-2">GET
            STARTED</v-btn>
        </div>
      </v-form>
      <div class="mt-2">
        <p class="text-body-2">
          Allready have an account?
          <router-link to="/signin">Sign In</router-link>
        </p>
      </div>
    </v-sheet>
  </div>
  <div v-else>LOADING</div>
</template>

<script>
// inports
import { mapActions, mapGetters, mapMutations } from "vuex";

export default {
  mounted() {
    // Once the content has finished loading
    this.contentLoaded = true;
  },
  data() {
    return {
      // name rules
      nameRules: [
        (v) => !!v || "The name field is required.",
        (v) => /.{2,}/.test(v) || "Name must contain minimum 2 letters",
      ],
      // email rules
      emailRules: [
        (v) => !!v || "The email field is required.",
        (v) =>
          !v ||
          /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "E-mail must be valid",
      ],
      //   password rules
      passwordRules: {
        required: (v) => !!v || "The password field is required.",
        min: (v) =>
          /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/.test(v) ||
          "Password must contain at least lowercase letter, one number, a special character and one uppercase letter",
      },
      // date rules
      dateStartRules: [
        (v) => !!v || "The education start date field is required.",
      ],
      // date rules
      dateEndRules: [
        (v) => !!v || "The education end date field is required.",
        (v) =>
          !!(new Date(this.education_start) < new Date(v)) ||
          "Must be a valid date and greater than education start date.",
      ],
      // trems rules
      termsRules: {
        required: (v) => !!v || "The terms field is required.",
      },
      //   input data
      name: "",
      email: "",
      password: "",
      verify: "",
      education_start: "",
      education_end: "",
      terms: false,
      contentLoaded: false,
      errors: this.getErrors,
      message: this.getMessage,
    };
  },
  computed: {
    ...mapGetters({ getErrors: "getErrors", getMessage: "getMessage" }),
    passwordMatch() {
      return () => this.password === this.verify || "Password must match";
    },
  },
  methods: {
    ...mapActions({ register: "register" }),
    ...mapMutations({ trimError: "trimError" }),
    signUp() {
      if (
        (this.name.trim(),
          this.email &&
          this.password &&
          this.verify &&
          this.education_start &&
          this.education_end &&
          !!(new Date(this.education_start) < new Date(this.education_end)) &&
          this.terms)
      ) {
        this.register({
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.verify,
          education_start_date: this.education_start,
          education_end_date: this.education_end,
          terms: this.terms,
        });
      } else if (!this.terms) {
        this.trimError();
      }
    },
  },
  watch: {
    getErrors: {
      handler() {
        this.errors = this.getErrors;
      },
    },
    getMessage: {
      handler() {
        this.message = this.getMessage;
      },
    },
  },
};
</script>

<style scoped>
.login {
  background: url("@/../public/images/login_background.jpg") no-repeat center center fixed;
  background-size: cover;
}
</style>
