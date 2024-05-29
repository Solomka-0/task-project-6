<template>
  <div class=tasks>
    <div ref="tasksRef" class="tasks__body">
      <!-- Добавление задачи -->
      <task :task="{name: 'Создать новую задачу'}" :style="'#d1c4ff'" class="text-white"
            @click="useTasks.selectTask({name: 'Моя задача', description: 'Описание', status: 'not started'}); ctx.isOpen = true"></task>
      <!-- Вывод задач -->
      <task :task="task" v-for="(task, index) in tasks" @click="openTaskForm(index)" :key="index" :id="`task${index}`">
      </task>
    </div>
    <div v-if="ctx.isOpen" class="tasks__modal-wrapper">
      <div class="tasks__modal">
        <div class="tasks__modal-headnote">
          <div @click="ctx.isOpen = false" class="tasks__modal-esc"/>

        </div>
        <div class="tasks__modal-content tasks__task">
          <div class="tasks__task-header">
            <div v-if="!ctx.form.edit.name" class="tasks__task-title" @click="ctx.form.edit.name = true">
              {{ useTasks.lastSelectedTask.name }}
            </div>
            <input v-else type="text" class="tasks__input-text tasks__task-title"
                   v-model="useTasks.lastSelectedTask.name"
                   @focusout="ctx.form.edit.name = false"/>
            <div class="task-status z-10" :style="{
              '--status-color': styles[useTasks.lastSelectedTask.status]
            }" @click.self="ctx.form.edit.status = true">
              {{ useTasks.lastSelectedTask.status }}
              <div v-if="ctx.form.edit.status" class="tasks__status-menu">
                <div v-for="(status, key) in styles" class="task-status" :style="{
              '--status-color': status}"
                     @click="ctx.form.edit.status = false; useTasks.lastSelectedTask.status = key;"
                >
                  {{ key }}
                </div>
              </div>
            </div>
          </div>
          <div v-if="!ctx.form.edit.description" class="tasks__task-description"
               @click="ctx.form.edit.description = true">
            {{ useTasks.lastSelectedTask.description }}
          </div>
          <textarea v-else type="text" class="tasks__input-text" v-model="useTasks.lastSelectedTask.description"
                    @focusout="ctx.form.edit.description = false"></textarea>
          <div class="tasks__task-footnote">
            <div v-if="!!useTasks.lastSelectedTask.id" class="btn" @click="removeTask">Удалить</div>
            <div v-if="!!useTasks.lastSelectedTask.id" class="btn btn_primary" @click="saveTask">Сохранить</div>
            <div v-if="!useTasks.lastSelectedTask.id" class="btn btn_primary" @click="createTask">Добавить</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang='ts'>
import {useDefaultState} from './composables/useDefault'
import {taskStatusesPalette} from "~/types/Common";
import {useTasksStore} from "~/stores/tasks";
import GetTasks from "~/api/endpoints/tasks/GetTasks";
import RemoveTask from "~/api/endpoints/tasks/RemoveTask";
import StoreTask from "~/api/endpoints/tasks/StoreTask";
import UpdateTask from "~/api/endpoints/tasks/UpdateTask";
import Task from "~/src/modules/MyTasks/components/Task/Task.vue";

const ctx = useDefaultState()

// i18
const i18nPrefix = "components.Tasks"
const nuxtApp = useNuxtApp()
const $i = nuxtApp.$i(i18nPrefix)

const tasks = defineModel<any>('tasks')
const emit = defineEmits(['update:tasks'])

const tasksRef = ref()

const styles = taskStatusesPalette

// Показываю что умею работать со stor-ами (хотя это не надобно)
const useTasks = useTasksStore()

function removeTask() {
  new RemoveTask().request(useTasks.lastSelectedTask!.id)
  tasks!.value = tasks!.value.filter((item) => item.id !== useTasks.lastSelectedTask!.id)
  useTasks.clearSelected()
  ctx.value.isOpen = false
}

async function createTask() {
  let response = await new StoreTask(useTasks.lastSelectedTask!).request(undefined, undefined, (response) => {
    tasks.value.push(response)
  })

  // Скроллинг до элемента
  tasksRef.value.children[tasksRef.value.children.length - 1].scrollIntoView()
  ctx.value.isOpen = false
  render()
}

function saveTask() {
  new UpdateTask().request(useTasks.lastSelectedTask!.id, useTasks.lastSelectedTask!)
  useTasks.clearSelected()
  ctx.value.isOpen = false
}

function openTaskForm(id: number) {
  useTasks.selectTask(tasks!.value[id])
  ctx.value.isOpen = true
}

function render() {
  let childs: HTMLCollection = tasksRef.value.children

  let topLeftBound = childs[0].getBoundingClientRect();
  let bottomRightBound = {
    x: topLeftBound.x,
    y: topLeftBound.y
  }

  // Ищу правую нижнуюю точку
  for (let i = 0; i < childs.length; i++) {
    let child = childs.item(i)
    let childBound = child.getBoundingClientRect()
    bottomRightBound.x = bottomRightBound.x < childBound.x ? childBound.x : bottomRightBound.x
    bottomRightBound.y = bottomRightBound.y < childBound.y ? childBound.y : bottomRightBound.y
  }

  for (let i = 0; i < childs.length; i++) {
    let child = childs.item(i)
    let childBound = child.getBoundingClientRect()

    let top = child.getElementsByClassName('task__dec_top')[0]
    let bottom = child.getElementsByClassName('task__dec_bottom')[0]
    let left = child.getElementsByClassName('task__dec_left')[0]
    let right = child.getElementsByClassName('task__dec_right')[0]

    // Ограничиваю прямоугольник
    // Левая граница
    if (childBound.x == topLeftBound.x) {
      child.getElementsByClassName('task__dec_left')[0]?.remove()
    }

    // Правая граница
    if (childBound.x == bottomRightBound.x) {
      child.getElementsByClassName('task__dec_right')[0]?.remove()
    }

    // Верхняя граница
    if (childBound.y == topLeftBound.y) {
      child.getElementsByClassName('task__dec_top')[0]?.remove()
    }

    // Нижняя граница
    if (childBound.y == bottomRightBound.y) {
      child.getElementsByClassName('task__dec_bottom')[0]?.remove()
    }

    // Рандомизирую элементы
    if (i < childs.length - 1) {
      try {
        if (Math.floor(Math.random() * 2)) {
          child.getElementsByClassName('task__dec_right')[0].classList.add('task__dec_hide')
        } else {
          childs[i + 1].getElementsByClassName('task__dec_left')[0].classList.add('task__dec_hide')
        }
      } catch (e) {

      }
    }
  }
}

onUpdated(() => {
  render()
})

onMounted(() => {
  render()
})
</script>

<style lang="scss">
@import "./style.scss";
</style>