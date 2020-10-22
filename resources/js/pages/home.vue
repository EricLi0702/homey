<template>
  <card :title="$t('home')">
    {{ $t('you_are_logged_in') }}
    <fetch-users></fetch-users>
    <Button type="primary">test</Button>
  </card>
</template>

<script>
import FetchUsers from '~/components/FetchUsers'
export default {
  components: {
    FetchUsers,
  },
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('home') }
  }
}
</script>
