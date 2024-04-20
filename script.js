const axios = require('axios');

// Dummy contacts data
const contacts = [
    { id: 1, email: 'contact1@example.com' },
    { id: 2, email: 'contact2@example.com' },
    // Add more contacts as needed
];

// Dummy messages data
const messages = [
    { id: 1, sender: 'You', text: 'Hello', timestamp: '2024-04-04 12:00:00' },
    { id: 2, sender: 'Friend', text: 'Hi there', timestamp: '2024-04-04 12:05:00' },
    // Add more messages as needed
];

// Function to add a new message to the chat
function addMessage(message) {
    console.log(message);
}

// Function to fetch contacts from the server
function fetchContacts() {
    return axios.get('http://http://localhost:3000/no/contacts')
        .then(response => {
            if (response.data.success) {
                return response.data.contacts;
            } else {
                console.error('Error:', response.data.error);
                return [];
            }
        })
        .catch(error => {
            console.error('Error: Failed to fetch contacts', error.message);
            return [];
        });
}

// Function to send message via API
function sendMessage(message) {
    return axios.post('http://http://localhost:3000//send-message', message)
        .then(response => {
            if (response.data.success) {
                addMessage(message);
            } else {
                console.error('Error:', response.data.error);
            }
        })
        .catch(error => {
            console.error('Error: Failed to send message', error.message);
        });
}

// Function to fetch messages from the server
function fetchMessages() {
    return axios.get('http://http://localhost:3000//fetch-messages')
        .then(response => {
            if (response.data.success) {
                response.data.messages.forEach(message => addMessage(message));
            } else {
                console.error('Error fetching messages:', response.data.error);
            }
        })
        .catch(error => {
            console.error('Failed to fetch messages. Please check your internet connection and try again.', error.message);
        });
}

// Main function to orchestrate the process
async function main() {
    const contacts = await fetchContacts();
    // Here you can process the contacts data

    await fetchMessages();
}

// Start the process
main();
