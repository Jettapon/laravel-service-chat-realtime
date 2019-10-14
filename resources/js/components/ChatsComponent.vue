<template>
  <div class="row">
    <div class="col-md-8" style="margin-bottom: 10px;">
      <div class="card card-default">
        <div class="card-header">Messages</div>
        <div class="card-body p-0">
          <ul class="list-unstyled" style="height:300px; overflow-y:scroll" v-chat-scroll>
            <li class="p-2" v-for="(message, index) in messages" :key="index">
              <strong>{{ message.user.name }}</strong>
              {{ message.msg }}
            </li>
          </ul>
        </div>
        <div class="input-group ">
          <input
            @keydown="sendTypingEvent"
            @keyup.enter="sendMessage"
            v-model="newMessage"
            type="text"
            name="message"
            placeholder="Enter your message..."
            class="form-control"
          />
          <button type="button" v-on:click="sendMessage" :disabled="newMessage == ''" class="btn btn-primary">Send</button>
        </div>
      </div>
      <span class="text-muted" v-if="activeUser">{{ activeUser.name }} is typing...</span>
    </div>

    <div class="col-md-4">
      <div class="card card-default">
        <div class="card-header">Active Users</div>
        <div class="card-body">
          <ul>
            <li class="py-2" v-for="(user, index) in users" :key="index">{{ user.name }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["user"],
  data() {
    return {
      messages: [],
      newMessage: "",
      users: [],
      activeUser: false,
      typingTimer: false
    };
  },
  created() {
    this.fetchMessages();
    Echo.join("chat")
      .here(user => {
        this.users = user;
      })
      .joining(user => {
        this.users.push(user);
      })
      .leaving(user => {
        this.users = this.users.filter(u => u.id != user.id);
      })
      .listen("msgSent", event => {
        this.messages.push(event.message);
      })
      .listenForWhisper("typing", user => {
        this.activeUser = user;
        console.log(user)
        if (this.typingTimer) {
          clearTimeout(this.typingTimer);
        }
        this.typingTimer = setTimeout(() => {
          this.activeUser = false;
        }, 3000);
      });
  },
  methods: {
    fetchMessages() {
      axios.get("msg").then(response => {
        this.messages = response.data;
      });
    },
    sendMessage() {
      this.messages.push({
        user: this.user,
        msg: this.newMessage
      });
      axios.post("msg", { message: this.newMessage });
      this.newMessage = "";
    },
    sendTypingEvent() {
      Echo.join("chat").whisper("typing", this.user);
    }
  }
};
</script>