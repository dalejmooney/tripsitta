<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Name" :name="fieldName('name')" type="text" in-store="value" ></a17-textfield><a17-datepicker label="DOB" :name="fieldName('dob')" place-holder="DOB" in-store="date"
></a17-datepicker>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
