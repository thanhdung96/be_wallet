<template>
  <base-material-card>
    <template v-slot:heading>
      <div class="display-2 font-weight-light">Edit Profile</div>

      <div class="subtitle-1 font-weight-light">
        Complete your profile
      </div>
    </template>

    <v-form @submit.prevent="saveProfile">
      <v-container class="py-0">
        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="account.username"
              class="purple-input"
              label="User Name"
              disabled
            />
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field
              v-model="account.email"
              class="purple-input"
              label="Email Address"
            />
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field
              v-model="account.firstName"
              class="purple-input"
              label="First Name"
            />
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field
              v-model="account.lastName"
              class="purple-input"
              label="Last Name"
            />
          </v-col>

          <v-col cols="12">
            <v-text-field
              v-model="account.address.address"
              class="purple-input"
              label="Address"
            />
          </v-col>

          <v-col cols="12" md="4">
            <v-text-field
              v-model="account.address.city"
              class="purple-input"
              label="City"
            />
          </v-col>

          <v-col cols="12" md="4">
            <v-text-field
              v-model="account.address.country"
              class="purple-input"
              label="Country"
            />
          </v-col>

          <v-col cols="12" md="4">
            <v-text-field
              v-model="account.address.postal"
              class="purple-input"
              label="Postal Code"
              type="number"
            />
          </v-col>

          <v-col cols="12">
            <v-textarea
              v-model="account.about"
              class="purple-input"
              label="About Me"
            />
          </v-col>

          <v-col cols="12" class="text-right">
            <v-btn
              color="success"
              type="submit"
              class="mr-0"
              rounded
            >
              Update Profile
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
    </v-form>
  </base-material-card>
</template>

<script>
import { customAxios } from '@/axios'

export default {
	name: "ProfileCard",

	data() {
		return {
			account: {
				username: null,
				email: null,
				firstName: null,
				lastName: null,
				address: {
					address: null,
					city: null,
          country: null,
					postal: null,
				},
				about: null,
			}
		}
	},

	created() {
		customAxios
			.post('api/account/')
      .then(response => {
        let data = response.data.account;

        this.account.username = data.name;
        this.account.email = data.email;
        this.account.firstName = data.firstName;
        this.account.lastName = data.lastName;
        this.account.address.address = data.address;
        this.account.address.city = data.city;
        this.account.address.country = data.country;
        this.account.address.postal = data.postal;
        this.account.about = data.about;
      })
      .catch(error => {
        swal('Oops!', error.data, 'error');
      });
	},

  methods: {
    saveProfile() {
      customAxios
        .post('/api/account/save', this.account)
        .then(response => {
          swal('Success!', response.data.message, 'success');
        })
        .catch(error => {
          swal('Oops!', error.data.message, 'error');
        });
    },
  },
}
</script>
