var app = require('express')();
var http = require('http').Server(app);
var https = require('http').Server(app);
const fs = require('fs');
const express = require('express');
const port = 9000;
const isProd = true;

var io = require('socket.io')(http);
//var db = require('./db');
//var mydb = new db();


/*const express = require('express');
const app = express();
const http = require('http');

var options = {
  key: fs.readFileSync('/etc/ssl/private/crzglobal_xyz.key'),
  cert: fs.readFileSync('/etc/ssl/certs/crzglobal_xyz.crt'),
  ca: fs.readFileSync('/etc/ssl/crzglobal_xyz.ca-bundle'),
};
const server = http.createServer(app);
const io = require('socket.io')(server);*/

//const server = http.createServer(app);
//const { Server } = require("socket.io");

//const io = new Server(server);

app.get('/', (req, res) => {
  res.sendFile(__dirname + '/index.html');
  //res.send('Socket Working Fine.');
});

io.on('connection', (socket) => {

	console.log('a user connected');
    
  socket.on('session_join_request_send', (data) => {
      console.log(data);
      io.emit('session_join_request_get', data);
  });
});

http.listen(port, () => {
  console.log('listening on *:'+port);
});
