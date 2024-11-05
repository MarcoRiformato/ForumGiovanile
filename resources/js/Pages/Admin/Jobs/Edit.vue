<template>
    <AppLayout title="Modifica posizione">
        <div :class="['bg-base-200', form.isCorso ? 'bg-secondary/10' : '']">
            <h1 class="text-4xl p-4">
                {{ form.isCorso ? 'Modifica corso' : 'Modifica posizione' }}
            </h1>
            <form class="px-8 bg-base-200 pb-8" @submit.prevent="submit">
                <div class="space-y-12">
                    <div class="border-b border-white/10 pb-12">
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <!-- Titolo e Tipo -->
                            <div class="sm:col-span-4 grid sm:grid-cols-4 gap-4">
                                <div class="sm:col-span-3">
                                    <label for="lavoro" class="block text-sm font-medium leading-6">
                                        {{ form.isCorso ? 'Titolo del corso' : 'Titolo' }}
                                    </label>
                                    <div class="mt-2">
                                        <input v-model="form.lavoro" type="text" 
                                            :placeholder="form.isCorso ? 'es: \'corso di inglese\', \'corso OSS\'' : 'es: \'cameriere\', \'barista\', \'sviluppatore\'' " 
                                            :class="['input input-bordered w-full max-w-xs', form.isCorso ? 'input-secondary' : 'input-primary']" />
                                    </div>
                                </div>
                                <div class="sm:col-span-1 flex items-end">
                                    <div class="form-control">
                                        <label class="label cursor-pointer">
                                            <span class="label-text mr-2">Si tratta di un corso?</span>
                                            <input v-model="form.isCorso" type="checkbox" 
                                                :class="['checkbox', form.isCorso ? 'checkbox-secondary' : 'checkbox-primary']" />
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Descrizione -->
                            <div class="col-span-full">
                                <label for="descrizione" class="block text-sm font-medium leading-6">
                                    {{ form.isCorso ? 'Descrizione del corso' : 'Descrizione' }}
                                </label>
                                <div class="mt-2">
                                    <textarea v-model="form.descrizione" rows="3" 
                                        :class="['block w-full textarea', form.isCorso ? 'textarea-secondary' : 'textarea-primary']">
                                    </textarea>
                                </div>
                            </div>

                            <!-- Azienda -->
                            <div class="col-span-full">
                                <label for="azienda" class="block text-sm font-medium leading-6">
                                    {{ form.isCorso ? 'Nome dell\'azienda/scuola' : 'Nome dell\'azienda' }}
                                </label>
                                <div class="mt-2">
                                    <input v-model="form.azienda" type="text" 
                                        :placeholder="form.isCorso ? 'Quale azienda organizza questo corso?' : 'Quale azienda offre questo lavoro?'" 
                                        :class="['input input-bordered w-full max-w-xs', form.isCorso ? 'input-secondary' : 'input-primary']" />
                                </div>
                            </div>

                            <!-- Luogo -->
                            <div class="col-span-full">
                                <label for="luogo" class="block text-sm font-medium leading-6">
                                    {{ form.isCorso ? 'Dove si svolge il corso' : 'Luogo' }}
                                </label>
                                <div class="mt-2 flex items-center gap-4">
                                    <input v-model="form.luogo" type="text" 
                                        :placeholder="form.isCorso ? 'Dove si svolge il corso?' : 'Dove lavorerà il dipendente?'" 
                                        :class="['input input-bordered w-full max-w-xs', form.isCorso ? 'input-secondary' : 'input-primary']"
                                        :disabled="form.isCorso && form.daCasa" />
                                    <div v-if="form.isCorso" class="form-control">
                                        <label class="label cursor-pointer">
                                            <span class="label-text mr-2">Da casa</span>
                                            <input v-model="form.daCasa" type="checkbox" 
                                                @change="handleDaCasaChange"
                                                class="checkbox checkbox-secondary" />
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Stipendio/Costo -->
                            <div class="col-span-full">
                                <label for="stipendio" class="block text-sm font-medium leading-6">
                                    {{ form.isCorso ? 'Costo del corso' : 'Retribuzione offerta' }}
                                </label>
                                <div class="mt-2 flex items-center gap-4">
                                    <input v-model="form.stipendio" type="text" 
                                        :placeholder="form.isCorso ? 'es: \'€ 500\', \'€ 1000 + IVA\'' : 'es: \'€ 1400-1600\', \'€ 7/ora\', \'su accordo\''" 
                                        :class="['input input-bordered w-full max-w-xs', form.isCorso ? 'input-secondary' : 'input-primary']"
                                        :disabled="form.isCorso && form.gratuito" />
                                    <div v-if="form.isCorso" class="form-control">
                                        <label class="label cursor-pointer">
                                            <span class="label-text mr-2">Gratuito</span>
                                            <input v-model="form.gratuito" type="checkbox" 
                                                @change="handleGratuitoChange"
                                                class="checkbox checkbox-secondary" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between gap-x-6">
                    <button @click="destroy" type="button" class="btn btn-error">Cancella</button>
                    <button @click="$inertia.visit(route('admin.jobs.index'))" type="button" 
                        class="btn btn-secondary">
                        Annulla
                    </button>
                    <button type="submit" :disabled="form.processing" 
                        :class="['btn', form.isCorso ? 'btn-secondary' : 'btn-primary']">
                        Salva
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    job: {
        type: Object,
        required: true
    }
})

let form = useForm({
    id: props.job.id,
    lavoro: props.job.lavoro,
    azienda: props.job.azienda,
    luogo: props.job.luogo,
    descrizione: props.job.descrizione,
    stipendio: props.job.stipendio,
    isCorso: Boolean(props.job.isCorso),
    daCasa: false,
    gratuito: false
});

// Initialize daCasa if luogo is "Da casa"
if (props.job.luogo === 'Da casa') {
    form.daCasa = true;
}

// Initialize gratuito if stipendio is "Gratuito"
if (props.job.stipendio === 'Gratuito') {
    form.gratuito = true;
}

const handleDaCasaChange = () => {
    if (form.daCasa) {
        form.luogo = 'Da casa';
    } else {
        form.luogo = '';
    }
};

const handleGratuitoChange = () => {
    if (form.gratuito) {
        form.stipendio = 'Gratuito';
    } else {
        form.stipendio = '';
    }
};

const submit = () => {
    form.put(route('admin.jobs.update', {id: form.id}), {
        onSuccess: () => {
            $inertia.visit(route('admin.jobs.index'));
        }
    });
}

const destroy = () => {
    form.delete(route('admin.jobs.destroy', {id: form.id}));
}
</script>

