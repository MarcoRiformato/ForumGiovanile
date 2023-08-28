<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, defineComponent, h } from 'vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'
import {
  AcademicCapIcon,
  CheckCircleIcon,
  HandRaisedIcon,
  RocketLaunchIcon,
  SparklesIcon,
  SunIcon,
  UserGroupIcon,
  BugAntIcon, ChatBubbleLeftRightIcon, ComputerDesktopIcon
} from '@heroicons/vue/20/solid'

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  const date = new Date(dateString);
  return date.toLocaleDateString('it-IT', options); // Italian format
};

const values = [
  {
    name: 'Be world-class.',
    description: 'Lorem ipsum, dolor sit amet consectetur adipisicing elit aute id magna.',
    icon: RocketLaunchIcon,
  },
  {
    name: 'Take responsibility.',
    description: 'Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo.',
    icon: HandRaisedIcon,
  },
  {
    name: 'Be supportive.',
    description: 'Ac tincidunt sapien vehicula erat auctor pellentesque rhoncus voluptas blanditiis et.',
    icon: UserGroupIcon,
  },
  {
    name: 'Always learning.',
    description: 'Iure sed ab. Aperiam optio placeat dolor facere. Officiis pariatur eveniet atque et dolor.',
    icon: AcademicCapIcon,
  },
  {
    name: 'Share everything you know.',
    description: 'Laudantium tempora sint ut consectetur ratione. Ut illum ut rem numquam fuga delectus.',
    icon: SparklesIcon,
  },
  {
    name: 'Enjoy downtime.',
    description: 'Culpa dolorem voluptatem velit autem rerum qui et corrupti. Quibusdam quo placeat.',
    icon: SunIcon,
  },
]
const team = [
  {
    name: 'Michael Foster',
    role: 'Co-Founder / CTO',
    imageUrl:
      'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80',
  },
  {
    name: 'Michael Foster',
    role: 'Co-Founder / CTO',
    imageUrl:
      'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80',
  },
  {
    name: 'Michael Foster',
    role: 'Co-Founder / CTO',
    imageUrl:
      'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80',
  },
  {
    name: 'Michael Foster',
    role: 'Co-Founder / CTO',
    imageUrl:
      'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80',
  },
  
  // More people...
]



defineProps({
    latestArticles: Array
})


</script>

<template>
<AppLayout title="Home">
  <div class="bg-base-200 force-center">

    <main class="isolate">
      <div class="relative isolate -z-10">
        <div class="overflow-hidden">
          <!-- Chi siamo -->
          
          <div class="-mt-10 mx-auto max-w-7xl px-6 pb-16 pt-10 sm:pt-30 lg:px-8 lg:pt-16">
            <div class="mx-auto max-w-2xl gap-x-14 lg:mx-0 lg:flex lg:max-w-none lg:items-center">
              <div class="w-full max-w-xl lg:shrink-0 xl:max-w-2xl">
                <h1 class="text-4xl font-bold tracking-tight  sm:text-6xl">Siamo il forum giovanile elbano</h1>
                <p class="relative mt-6 text-lg leading-8  sm:max-w-md lg:max-w-none">Cupidatat minim id magna ipsum sint dolor qui. Sunt sit in quis cupidatat mollit aute velit. Et labore commodo nulla aliqua proident mollit ullamco exercitation tempor. Sint aliqua anim nulla sunt mollit id pariatur in voluptate cillum. Eu voluptate tempor esse minim amet fugiat veniam occaecat aliqua.</p>
              </div>
            </div>
          </div>

          <!-- Preview notizie -->
        <div class="relative isolate -z-10">
        </div>
        <div class="mx-auto max-w-7xl px-6 sm:mt-4 lg:px-8">
          <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Ultime notizie</h2>
            <p class="mt-2 text-lg leading-8 ">Leggi analisi, sondaggi e notizie del Forum Giovanile Elbano</p>
          </div>
          <div class="mx-auto mt-16 grid auto-rows-fr grid-cols-2 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 gap-8 sm:mt-20">
            <article v-for="(article, index) in latestArticles" :key="index"
class="relative flex flex-col justify-end overflow-hidden rounded-2xl bg-gray-900 px-8 pb-8 pt-80 sm:pt-48 lg:pt-80">
    <img src="https://picsum.photos/800" alt="" class="absolute inset-0 z-0 h-full w-full object-cover" />
    <div class="absolute inset-0 z-10 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
    <div class="absolute inset-0 z-10 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
    <div class="flex flex-wrap items-center gap-y-1 overflow-hidden text-sm leading-6 z-20">
        <time :created_at="article.created_at" class="mr-8">{{ formatDate(article.created_at) }}</time>
        <div class="-ml-4 flex items-center gap-x-4">
            <svg viewBox="0 0 2 2" class="-ml-0.5 h-0.5 w-0.5 flex-none fill-white/50"></svg>
            <div class="flex gap-x-2.5">
                <img src="https://picsum.photos/100" alt="" class="h-6 w-6 flex-none rounded-full bg-white/10" />
                <p>{{ article.user.name }}</p>
            </div>
        </div>
    </div>
    <h3 class="mt-3 text-lg font-semibold leading-6 text-white z-20">
        <p>
          <span class="absolute inset-0" />
          {{ article.title }}
        </p>
    </h3>
</article>

          </div>
        </div>
        </div>
      </div>

      <!-- La nostra visione -->
      <div class="relative isolate -z-10">
        </div>
        <div class="mx-auto max-w-7xl px-6 sm:mt-40 lg:px-8" style="margin-top: 5rem !important;">

        <div class="mx-auto max-w-2xl lg:mx-0">
          <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">La nostra visione</h2>
          <p class="mt-6 text-lg leading-8 text-gray-300">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor cupiditate blanditiis.</p>
        </div>
        <dl class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 text-base leading-7 text-gray-300 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:gap-x-16">
          <div v-for="value in values" :key="value.name" class="relative pl-9">
            <dt class="inline font-semibold text-white">
              <component :is="value.icon" class="absolute left-1 top-1 h-5 w-5 text-indigo-500" aria-hidden="true" />
              {{ value.name }}
            </dt>
            {{ ' ' }}
            <dd class="inline">{{ value.description }}</dd>
          </div>
        </dl>
      </div>
      
      <!-- Immagine larga -->
      <div class="mt-12 sm:mt-40 xl:mx-auto xl:max-w-7xl xl:px-8">
        <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2832&q=80" alt="" class="aspect-[5/2] w-full object-cover xl:rounded-3xl" />
      </div>

      <!-- La squadra -->
      <div class="mx-auto mt-8 max-w-7xl px-6 sm:mt-48 lg:px-8">
        <div class="mx-auto max-w-2xl lg:mx-0">
          <h2 class="text-3xl font-bold tracking-tight  sm:text-4xl">Our team</h2>
          <p class="mt-6 text-lg leading-8 ">Sit facilis neque ab nulla vel. Cum eos in laudantium. Temporibus eos totam in dolorum. Nemo vel facere repellendus ut eos dolores similique.</p>
        </div>
        <ul role="list" class="mx-auto mt-20 grid max-w-2xl grid-cols-2 gap-x-8 gap-y-16 text-center sm:grid-cols-3 md:grid-cols-4 lg:mx-0 lg:max-w-none lg:grid-cols-5 xl:grid-cols-6">
          <li v-for="person in team" :key="person.name">
            <img class="mx-auto h-24 w-24 rounded-full" :src="person.imageUrl" alt="" />
            <h3 class="mt-6 text-base font-semibold leading-7 tracking-tight ">{{ person.name }}</h3>
            <p class="text-sm leading-6 ">{{ person.role }}</p>
          </li>
        </ul>
      </div>
      
      <!--Contattaci-->
      <div class="isolate bg-base-200 px-6 py-24 sm:py-32 lg:px-8">
    <div class="mx-auto max-w-2xl sm:text-center">
      <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Contattaci</h2>
      <p class="mt-2 text-lg leading-8 ">Aute magna irure deserunt veniam aliqua magna enim voluptate.</p>
    </div>
    <div class="mx-auto mt-20 max-w-lg space-y-16">
      <div class="flex gap-x-6">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-indigo-600">
          <ChatBubbleLeftRightIcon class="h-6 w-6 text-white" aria-hidden="true" />
        </div>
        <div>
          <h3 class="text-base font-semibold leading-7">Scrivici su whatsapp</h3>
          <p class="mt-2 leading-7">Ut cursus est ut amet. Lobortis eget egestas leo vitae eget porttitor risus blandit. Nunc a in lorem vel iaculis porttitor.</p>
          <p class="mt-4">
            <a href="#" class="text-sm font-semibold leading-6 ">Contact us <span aria-hidden="true">&rarr;</span></a>
          </p>
        </div>
      </div>
      <div class="flex gap-x-6">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-indigo-600">
          <BugAntIcon class="h-6 w-6 text-white" aria-hidden="true" />
        </div>
        <div>
          <h3 class="text-base font-semibold leading-7">Inviaci una email</h3>
          <p class="mt-2 leading-7">Expedita qui non ut quia ipsum voluptatum ipsam pariatur. Culpa vitae ipsum minus eius vero quo quibusdam.</p>
          <p class="mt-4">
            <a href="#" class="text-sm font-semibold leading-6 ">Report a bug <span aria-hidden="true">&rarr;</span></a>
          </p>
        </div>
      </div>
    </div>
      </div>
    
    </main>

    <!-- Footer 
    <footer class="bg-base-200 -mt-12">
    <div class="mx-auto max-w-7xl -mt-30 overflow-hidden px-6 py-20 sm:py-24 lg:px-8">
      <div class="mt-10 flex justify-center space-x-10">
        <a v-for="item in navigation.social" :key="item.name" :href="item.href" class=" hover:text-gray-500">
          <span class="sr-only">{{ item.name }}</span>
          <component :is="item.icon" class="h-6 w-6" aria-hidden="true" />
        </a>
      </div>
      <p class="mt-10 text-center text-xs leading-5 ">&copy; 2023 Riformato Marco. All rights reserved.</p>
    </div>
  </footer>-->
  </div>
</AppLayout>
</template>

<style>
  @media (max-width: 640px) {
    .grid-cols-2 {
      grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
    }
  }

  @media (min-width: 641px) and (max-width: 870px) {
    .grid-cols-2 {
      grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
    }
  }

  @media (min-width: 871px) {
    .grid-cols-2 {
      grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }
  }
</style>