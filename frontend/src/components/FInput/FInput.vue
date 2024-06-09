<template>
  <div class="f-input">
    <div class="f-input">
      <input v-if="type === 'checkbox'" class="f-input__input_checkbox" :value="value" @input="onInput"
             type="checkbox"/>
      <select v-else-if="type === 'select'" class="f-input__input" :value="value" @input="onInput">
        <option :value="null">
          - Выберите вариант -
        </option>
        <option v-for="selectOption in selectOptions" :value="selectOption.value ?? selectOption.id">
          {{ selectOption.caption ?? selectOption.name }}
        </option>
      </select>
      <input v-else class="f-input__input"
             v-model="model"
             :value="model ?? value"
             @input="onInput"
             :type="type"
             :placeholder="placeholder"
             :class="inputClass"
             :readonly="readonly"
             v-maska
             :data-maska="dataMaska"
             :data-maska-tokens="dataTokens"
             :data-maska-eager="dataMaskaEager"
      />
      <label v-if="!!labelText && type !== 'checkbox'" class="f-input__label">
        {{ labelText }}
      </label>
    </div>
  </div>
</template>

<script setup lang="ts">
// i18n
import type {Ref} from "@vue/reactivity";

const {t} = useI18n()
const localePath = useLocalePath()
const i18nPrefix = "components.ui.finput."

const model = defineModel<any>()

const value: Ref<null | string | boolean> = ref('')
const isValid: Ref<null | boolean> = ref(null)

const props = withDefaults(defineProps<{
  placeholder?: string,
  name: string,
  value?: null | string | boolean,
  type?: string,
  dataMaska?: string,
  dataTokens?: string,
  dataMaskaEager?: boolean,
  labelText?: string
  inputClass?: string,
  selectOptions?: { value: any, caption: string }[]
  required?: boolean
  readonly?: boolean
  minLength?: string
  min?: string
}>(), {
  required: false,
  value: ''
})

const emit = defineEmits(['update:value'])

const onInput = (event) => {
  if (event instanceof CustomEvent && event.detail) {
    emit('update:value', event.detail.unmasked)
  }
}


defineExpose({
  value,
  props
})

// const onChange = () => {
//   console.log(props.value?.value)
// }

onMounted(() => {
  value.value = props.value
})


</script>

<style lang="scss">
@import "scss/finput.scss";
</style>