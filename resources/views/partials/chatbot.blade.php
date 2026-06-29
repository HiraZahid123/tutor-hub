<!-- Chatbot Toggle Button -->
<button id="chat-toggle-button" class="chat-toggle-button" aria-label="Open Chat" onclick="toggleChat()">💬</button>

<!-- Chatbot Window -->
<div id="chatbot-container" class="chatbot-container" style="display: none;">
    <div class="chat-header">
        TutorHub Helper
        <button class="close-chat-button" aria-label="Close Chat" onclick="toggleChat()">×</button>
    </div>
    <div class="message-list" id="message-list"></div>
    <form class="input-area" id="chat-form" onsubmit="handleSendMessage(event)">
        <input type="text" id="chat-input" placeholder="Type your message..." aria-label="Chat input" autocomplete="off">
        <button type="submit">Send</button>
    </form>
</div>

@push('scripts')
<script>
const BOT_NAME = "TutorHub Helper";
const CONTACT_EMAIL = "help.tutorhub@gmail.com";
const responses = {
    GREETING_INITIAL: `Hi there! 👋 Welcome to Tutor Hub! I'm ${BOT_NAME}, your friendly guide. How can I help you today? (e.g., "What is Tutor Hub?", "How do I find a tutor?")`,
    RESPONSE_WHAT_IS: "Great question! Tutor Hub is an online platform connecting students with qualified tutors for various subjects. Search, book, and manage sessions easily!",
    RESPONSE_FIND_TUTOR: "Easy! Go to 'Find a Tutor', filter by subject/level, browse profiles (check qualifications, reviews), and book directly.",
    RESPONSE_STUDENT_GUIDE: "1. Sign Up. 2. Search/Filter tutors. 3. View profiles/Connect. 4. Book sessions. 5. Attend online. 6. Manage in your dashboard.",
    RESPONSE_TUTOR_GUIDE: `Fantastic! Look for 'Become a Tutor' or 'Teach with Us'. Fill the application (details, experience, subjects). We review it, and if approved, you set up your profile! For specific help: ${CONTACT_EMAIL}`,
    RESPONSE_HELP_CONTACT: `For technical issues, billing, or specific problems I can't solve, please email our support team at: ${CONTACT_EMAIL}. Provide details for faster help!`,
    RESPONSE_CANNOT_HELP: "Sorry, we can't help you with this.",
    RESPONSE_REFUSE_ABUSIVE: "I can't engage with that. My purpose is to help you use Tutor Hub. How can I assist with finding tutors or understanding features?",
    RESPONSE_UNKNOWN: "Hmm, I'm not sure I understand. Could you rephrase? Or ask about finding tutors, signing up, or contact support for specific issues.",
    EXIT_MESSAGE: "Okay, goodbye! Feel free to reach out anytime. Have a great day!"
};
const ABUSIVE_KEYWORDS = ["stupid", "idiot", "dumb", "hate", "sucks", "terrible", "awful", "useless", "crap"];
const EXIT_KEYWORDS = ["bye", "exit", "quit", "goodbye", "stop"];

let isChatOpen = false;
let hasGreeted = false;

function getBotResponse(userMessage) {
    const msgLower = userMessage.toLowerCase().trim();
    if (EXIT_KEYWORDS.some(word => msgLower.includes(word))) return { text: responses.EXIT_MESSAGE, isExit: true };
    if (ABUSIVE_KEYWORDS.some(word => msgLower.includes(word))) return { text: responses.RESPONSE_REFUSE_ABUSIVE };
    if (msgLower.includes("help") || msgLower.includes("support") || msgLower.includes("contact") || msgLower.includes("problem") || msgLower.includes("issue")) return { text: responses.RESPONSE_HELP_CONTACT };
    if ((msgLower.includes("find") || msgLower.includes("search") || msgLower.includes("look for")) && msgLower.includes("tutor")) return { text: responses.RESPONSE_FIND_TUTOR };
    if ((msgLower.includes("how use") || msgLower.includes("get started") || msgLower.includes("sign up")) && msgLower.includes("student")) return { text: responses.RESPONSE_STUDENT_GUIDE };
    if ((msgLower.includes("become tutor") || msgLower.includes("apply tutor") || msgLower.includes("teach") || msgLower.includes("sign up")) && (msgLower.includes("tutor") || msgLower.includes("teach"))) return { text: responses.RESPONSE_TUTOR_GUIDE };
    if (msgLower.includes("what is") || msgLower.includes("about") || msgLower.includes("explain")) return { text: responses.RESPONSE_WHAT_IS };
    if (msgLower.includes("hi") || msgLower.includes("hello") || msgLower.includes("hey")) return { text: `Hello again! ${responses.RESPONSE_WHAT_IS}` };
    return { text: responses.RESPONSE_CANNOT_HELP };
}

function toggleChat() {
    isChatOpen = !isChatOpen;
    const container = document.getElementById('chatbot-container');
    const toggleBtn = document.getElementById('chat-toggle-button');

    if (isChatOpen) {
        container.style.display = 'flex';
        toggleBtn.style.display = 'none';
        if (!hasGreeted) {
            addMessage(responses.GREETING_INITIAL, 'bot');
            hasGreeted = true;
        }
        document.getElementById('chat-input').focus();
    } else {
        container.style.display = 'none';
        toggleBtn.style.display = 'flex';
    }
}

function addMessage(text, sender) {
    const messageList = document.getElementById('message-list');
    const msgDiv = document.createElement('div');
    msgDiv.className = `message ${sender}-message`;
    msgDiv.textContent = text;
    messageList.appendChild(msgDiv);
    messageList.scrollTop = messageList.scrollHeight;
}

function handleSendMessage(e) {
    e.preventDefault();
    const input = document.getElementById('chat-input');
    const text = input.value.trim();
    if (!text) return;

    addMessage(text, 'user');
    input.value = '';

    const reply = getBotResponse(text);
    setTimeout(() => addMessage(reply.text, 'bot'), 500);
}

// Close chat on outside click
document.addEventListener('mousedown', function(e) {
    const container = document.getElementById('chatbot-container');
    const toggleBtn = document.getElementById('chat-toggle-button');
    if (isChatOpen && container && !container.contains(e.target) && toggleBtn && !toggleBtn.contains(e.target)) {
        toggleChat();
    }
});
</script>
@endpush
