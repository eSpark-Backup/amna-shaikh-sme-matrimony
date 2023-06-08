    const app = require('express')();
    const https = require('https');
    var http = require('http');
    var fs = require( 'fs' );
    //var options = {};
    var options = {
        key: fs.readFileSync('crzglobal_xyz.key'),
        cert: fs.readFileSync('crzglobal_xyz.crt'),
        ca: fs.readFileSync('crzglobal_xyz.ca-bundle'),

        requestCert: false,
        rejectUnauthorized: false
    }

    const server = https.createServer(options, app);
    //const server = http.createServer(app);


    const io = require('socket.io')(server,{ cors: true,  originxdsf: '*'  });
    //4-08-22

    let arr = [];
    let sessions = {};
    let communityChats = {};
    let comId = '';
    const updateSessionInfo = (sessionID) => {
        if (!sessionID) {
            console.log('sessionID undefined', sessionID);
            return;
        }

        let totalConnectedUsers = Object.values(sessions[sessionID])
            .filter((s, i, a) => s.status === 'connected').length;

        console.log('totalConnected', totalConnectedUsers);

        io.to(sessionID).emit('update_session_info', {
            host_session_id: sessionID,
            viewing: totalConnectedUsers,
            viewers: Object.values(sessions[sessionID])
        });

        if(totalConnectedUsers > 0){
            new db().updateViewCount(sessionID, totalConnectedUsers ? totalConnectedUsers : 0);
        }
    };

    server.listen(9000, () => {
        // console.log(socket.id);
      console.log('listening on *:9000');
    });
    app.get("/", function(request, response){
        // code goes here...
        //res.sendFile(__dirname + '/index.html');
        response.send('Socket Working Fine.');
    });



    io.on('connection', (socket) => {
        console.log(socket.id);
        console.log('a user connected');
        socket.emit("connected",{status: "connected", id: socket.id})

        socket.on("typing", function(data){
            console.log(data)
            if(data.typing){
                io.timeout(2000).emit("sender_typing", data)
            }
        })

        socket.on("send_message", function(data){
            console.log(data)
        })
        socket.on('session_join_request_send', (data) => {
          console.log(data);
          io.emit('session_join_request_get', data);
        });
        //
        socket.on('get_chat_read', function (data) {
            io.emit('send_chat_read', {
                'chatId ': data.chatId,
                'MessageId ': data.MessageId,
            });
        });
        //delete message
        socket.on('get_delete', function (data) {
            io.emit('send_delete', {
                'chatId ': data.chatId,
                'MessageId ': data.MessageId,
            });
        });
    });



