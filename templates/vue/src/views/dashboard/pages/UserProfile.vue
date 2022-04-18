<template>
  <v-container id="user-profile" fluid tag="section">
    <v-row justify="center">
      <v-col cols="12" md="8">
        <ProfileCard />
      </v-col>

      <v-col cols="12" md="4">
        <AccountSettingCard />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import ProfileCard from "@/views/dashboard/components/Profile/ProfileCard";
import AccountSettingCard from "@/views/dashboard/components/Profile/AccountSettingCard";

export default {
  name: "UserProfile",

  components: {
    ProfileCard,
    AccountSettingCard,
  },
};
</script>
