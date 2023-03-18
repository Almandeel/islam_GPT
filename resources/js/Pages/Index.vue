<template>
    <div class="flex items-center justify-center h-screen bg-red-lightest ">
        <Loader ref="Loader"></Loader>
        <div class="flex flex-col">
            <div class="overlay"></div>
            <div class="basis-1/2">
                <audio v-show="hasAudio" :src="audio_src" controls autoplay="true"></audio>

                <tapir-widget v-show="!hasAudio" ref="audio" backendEndpoint="/audio"  :time="2" buttonColor="white"/>
            </div>
            <div class="basis-1/2">
                <button
                    class="border border-gray-light bg-white p-3 w-full rounded shadow-lg transition ease-in duration-300 my-3 "
                    @click="hasAudio ? reSet() : approveOrder()"
                >
                {{ hasAudio ? 'Resend' : 'Submit'  }}
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import TapirWidget from 'vue-audio-tapir';
import 'vue-audio-tapir/dist/vue-audio-tapir.css';
export default {
    components : {
        TapirWidget
    },
    data() {
        return {
            hasAudio : false,
            audio_src : '',
            blob_audio : this.$refs.audio != '' ? true : false
        }
    },
    watch : {
        blob_audio(newData, oldData) {
            this.blob_audio = newData
        }
    },
    methods : {
        approveOrder() {
            this.$refs.Loader.toggleLoader();
            this.hasAudio = true
            const formData = new FormData();
            formData.append('file', this.$refs.audio.recordedBlob);
            axios.post(`/audio`, formData).then(response => {
                this.$refs.Loader.toggleLoader();
                this.hasAudio = true;
                this.audio_src = response.data;
            })
        },
        reSet() {
            this.hasAudio = false;
            this.hasAudio = false;
            this.audio_src = '';

        }
    }
}
</script>
