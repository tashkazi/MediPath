const express = require('express');
const http = require('http');
const socketIo = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// Serve static files (e.g., HTML, CSS, client-side JavaScript)
app.use(express.static(__dirname + '/public'));

// Event handling when a client connects
io.on('connection', (socket) => {
    console.log('A user connected');

    // Event handling when a client sends a message
    socket.on('message', (message) => {
        console.log('Message received:', message);

        // Broadcast the received message to all clients
        io.emit('message', message);
    });
    app.use('/socket.io', express.static(__dirname + '/node_modules/socket.io/client-dist'));

    // Event handling when a client disconnects
    socket.on('disconnect', () => {
        console.log('A user disconnected');
    });
});

const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});
