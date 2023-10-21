<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { format } from 'date-fns'
import { onMounted, ref } from 'vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    messages: Array,
    sender: Object,
    receiver: Object,
});

const messages = ref([]);
const new_message = ref([]);

onMounted(() => {
    messages.value = props.messages;

    // pusherの受信設定 (サーバーからWebsocket経由でメッセージを受け取ったときの処理を定義。以降この処理が自動で発火するため1度きりの定義でOK？)
    window.Echo.channel('channel-message-sent').listen('MessageSent', (res) => {
        messages.value.push(res.message);
        console.log("【受信成功】")
    });
})

function sendMessage()
{
    // 何も入力していなければ送信しない
    if (!(new_message.value.replace(/\s+/g,'').length > 0)) return;

    axios.post(route('chat.store', {'sender': props.sender.id, 'receiver': props.receiver.id }), {
            'context': new_message.value,
        })
        .then((res) => {
            messages.value.push(res.data);
            new_message.value = [];
        })
        .catch((err) => {
            console.log('500 Server Error.');
            console.log(err);
        })
}
</script>

<template>
    <Head title="Chat" />

    <div class="py-12">
        <ul>
            <li v-for="message in messages" class="mb-2">
                <p>【メッセージ: {{ format(new Date(message.created_at), 'yyyy-MM-dd HH:mm:ss') }}】</p>
                <p>送信者: {{ message.sender.name }}</p>
                <p>受信者: {{ message.receiver.name }}</p>
                <p>内容: {{ message.context }}</p>
            </li>
        </ul>
    </div>
    <div>
        <TextInput class="mr-4" v-model="new_message" />
        <PrimaryButton type="submit" @click="sendMessage()">送信</PrimaryButton>
    </div>
</template>
