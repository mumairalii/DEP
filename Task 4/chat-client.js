// Establish a WebSocket connection
const socket = new WebSocket('ws://localhost:8080');

// DOM elements
const chatMessages = document.getElementById('chat-messages');
const chatForm = document.getElementById('chat-form');
const messageInput = document.getElementById('message-input');
const fileInput = document.getElementById('file-input');
const fileList = document.getElementById('file-list');
const notificationArea = document.getElementById('notification-area');

// Event listener for form submission
chatForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const message = messageInput.value.trim();
    if (message) {
        sendMessage(message);
        messageInput.value = '';
    }
    if (fileInput.files.length > 0) {
        sendFile(fileInput.files[0]);
        fileInput.value = '';
    }
});

// Function to send a message
function sendMessage(message) {
    if (socket.readyState === WebSocket.OPEN) {
        socket.send(JSON.stringify({ type: 'message', content: message }));
        displayMessage({ type: 'message', sender: 'You', content: message }, true);
    }
}

// Function to send a file
function sendFile(file) {
    const reader = new FileReader();
    reader.onload = (e) => {
        const fileData = e.target.result.split(',')[1]; // Get base64 data
        socket.send(JSON.stringify({
            type: 'file',
            name: file.name,
            data: fileData
        }));
        showNotification(`File "${file.name}" sent successfully!`);
    };
    reader.readAsDataURL(file);
}

// Event listener for incoming messages
socket.addEventListener('message', (event) => {
    const message = JSON.parse(event.data);
    if (message.type === 'message') {
        displayMessage(message);
        showNotification(`New message from ${message.sender}`);
    } else if (message.type === 'file') {
        displayFile(message);
        showNotification(`${message.sender} shared a file: ${message.name}`);
    }
});

// Function to display a message
function displayMessage(message, sent = false) {
    const messageElement = document.createElement('div');
    messageElement.className = `message ${sent ? 'sent' : ''}`;
    messageElement.textContent = `${message.sender}: ${message.content}`;
    chatMessages.appendChild(messageElement);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Function to display a file
function displayFile(file) {
    const fileElement = document.createElement('div');
    fileElement.className = 'file-message';
    fileElement.textContent = `${file.sender} shared a file: `;
    const fileLink = document.createElement('a');
    fileLink.href = `/uploads/${file.name}`;
    fileLink.textContent = file.name;
    fileLink.target = '_blank';
    fileElement.appendChild(fileLink);
    chatMessages.appendChild(fileElement);
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Add to the shared files list
    const listItem = document.createElement('li');
    const listItemLink = fileLink.cloneNode(true);
    listItem.appendChild(listItemLink);
    fileList.appendChild(listItem);
}

// Function to show a notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    notificationArea.appendChild(notification);

    // Trigger reflow to enable the transition
    notification.offsetHeight;

    // Add the 'show' class to trigger the transition
    notification.classList.add('show');

    // Remove the notification after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notificationArea.removeChild(notification);
        }, 300);
    }, 3000);
}

// Event listener for WebSocket connection open
socket.addEventListener('open', () => {
    console.log('WebSocket connection established');
    showNotification('Connected to the chat server');
});

// Event listener for WebSocket connection close
socket.addEventListener('close', () => {
    console.log('WebSocket connection closed');
    showNotification('Disconnected from the chat server');
});

// Event listener for WebSocket errors
socket.addEventListener('error', (error) => {
    console.error('WebSocket error:', error);
    showNotification('An error occurred with the chat connection');
});
