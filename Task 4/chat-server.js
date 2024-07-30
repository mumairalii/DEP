const WebSocket = require('ws');
const http = require('http');
const fs = require('fs');
const path = require('path');

// Create an HTTP server
const server = http.createServer((req, res) => {
    // Serve static files
    const filePath = path.join(__dirname, 'public', req.url === '/' ? 'index.html' : req.url);
    const extname = path.extname(filePath);
    let contentType = 'text/html';

    switch (extname) {
        case '.js':
            contentType = 'text/javascript';
            break;
        case '.css':
            contentType = 'text/css';
            break;
    }

    fs.readFile(filePath, (error, content) => {
        if (error) {
            if (error.code === 'ENOENT') {
                res.writeHead(404);
                res.end('File not found');
            } else {
                res.writeHead(500);
                res.end('Internal server error');
            }
        } else {
            res.writeHead(200, { 'Content-Type': contentType });
            res.end(content, 'utf-8');
        }
    });
});

// Create a WebSocket server by passing the HTTP server
const wss = new WebSocket.Server({ server });

// Store connected clients
const clients = new Set();

// WebSocket server event listeners
wss.on('connection', (ws) => {
    // Add the new client to the set
    clients.add(ws);

    console.log('New client connected');

    // Send a welcome message to the new client
    ws.send(JSON.stringify({ type: 'message', sender: 'Server', content: 'Welcome to the chat!' }));

    // Event listener for messages from clients
    ws.on('message', (message) => {
        const parsedMessage = JSON.parse(message);

        if (parsedMessage.type === 'message') {
            // Broadcast the message to all connected clients
            broadcast({ type: 'message', sender: 'User', content: parsedMessage.content });
        } else if (parsedMessage.type === 'file') {
            // Save the file
            const filePath = path.join(__dirname, 'public', 'uploads', parsedMessage.name);
            fs.writeFile(filePath, parsedMessage.data, 'base64', (err) => {
                if (err) {
                    console.error('Error saving file:', err);
                } else {
                    // Broadcast the file information to all connected clients
                    broadcast({ type: 'file', sender: 'User', name: parsedMessage.name });
                }
            });
        }
    });

    // Event listener for client disconnection
    ws.on('close', () => {
        // Remove the client from the set
        clients.delete(ws);
        console.log('Client disconnected');
    });
});

// Function to broadcast a message to all connected clients
function broadcast(message) {
    clients.forEach((client) => {
        if (client.readyState === WebSocket.OPEN) {
            client.send(JSON.stringify(message));
        }
    });
}

// Start the server
const PORT = process.env.PORT || 8080;
server.listen(PORT, () => {
    console.log(`WebSocket server is running on port ${PORT}`);
});
