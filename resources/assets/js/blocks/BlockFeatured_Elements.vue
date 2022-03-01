<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Small title" :name="fieldName('small_title')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Title" :name="fieldName('title')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Button text" :name="fieldName('button_text')" type="text" in-store="value" ></a17-textfield><a17-vselect label="Type" :name="fieldName('type')" :options='[{&quot;value&quot;:1,&quot;label&quot;:&quot;Babysitters&quot;},{&quot;value&quot;:2,&quot;label&quot;:&quot;Places&quot;}]' placeholder="Select featured element" :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect><a17-inputframe label="Button url" name="browsers.pages"> <a17-browserfield :name="fieldName('pages')" item-label="button url" :max="1" :wide="false" endpoint="/admin/cms/pages/browser" :endpoints="[]" modal-title="Attach button url" :draggable="true" >Add one button url</a17-browserfield></a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
