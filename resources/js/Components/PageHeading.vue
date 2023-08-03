<template>
    <div class="lg:flex lg:items-center lg:justify-between">
      <div class="min-w-0 flex-1">
        <nav class="flex" aria-label="Breadcrumb">
          <ol role="list" class="flex items-center space-x-4">
            <li>
              <div class="flex">
                <a :href="pageHeaderInfo.FirstLink" class="text-sm font-medium">{{ pageHeaderInfo.FirstStep }}</a>
              </div>
            </li>
            <li>
              <div class="flex items-center">
                <ChevronRightIcon class="h-5 w-5 flex-shrink-0" aria-hidden="true" />
                <a href="#" class="ml-4 text-sm font-medium">{{ pageHeaderInfo.SecondStep }}</a>
              </div>
            </li>
            <li>
              <div class="flex items-center">
                <ChevronRightIcon v-if="pageHeaderInfo.ThirdStep" class="h-5 w-5 flex-shrink-0" aria-hidden="true" />
                <a href="#" class="ml-4 text-sm font-medium">{{ pageHeaderInfo.ThirdStep }}</a>
              </div>
            </li>
          </ol>
        </nav>
        <h2 class="mt-2 text-2xl font-bold leading-7 sm:truncate sm:text-3xl sm:tracking-tight">{{ pageHeaderInfo.SecondStep }}</h2>
        <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
          <div class="mt-2 flex items-center text-sm">
            <BriefcaseIcon v-if="pageHeaderInfo.status == 0" class="mr-1.5 h-5 w-5 flex-shrink-0" aria-hidden="true">
                
            </BriefcaseIcon>
            <BriefcaseIcon v-if="pageHeaderInfo.status == 1" class="mr-1.5 h-5 w-5 flex-shrink-0" aria-hidden="true">
                <p>Non attivo</p>
            </BriefcaseIcon>
          </div>
          <div class="mt-2 flex items-center text-sm">
            <MapPinIcon v-if="pageHeaderInfo.testing" class="mr-1.5 h-5 w-5 flex-shrink-0" aria-hidden="true" />
            {{ pageHeaderInfo.testing }}
          </div>
        </div>
      </div>
      <div class="mt-5 flex lg:ml-4 lg:mt-0">
        <span class="hidden sm:block">
          <button type="button" class="btn btn-secondary">
            <PencilIcon class="-ml-0.5 mr-1.5 h-5 w-5" aria-hidden="true" />
            Edit
          </button>
        </span>
  
        <span class="ml-3 hidden sm:block">
          <button type="button" class="btn btn-primary">
            <LinkIcon class="-ml-0.5 mr-1.5 h-5 w-5" aria-hidden="true" />
            View
          </button>
        </span>
      </div>
    </div>
  </template>
  
  <script setup>
  import {
    BriefcaseIcon,
    CalendarIcon,
    CheckIcon,
    ChevronDownIcon,
    ChevronRightIcon,
    CurrencyDollarIcon,
    LinkIcon,
    MapPinIcon,
    PencilIcon,
  } from '@heroicons/vue/20/solid'
  import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'


  const props = defineProps({
    pageHeaderInfo: Object
})

  </script>