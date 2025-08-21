class RealtimeMessageHandler {
    constructor() {
        this.subscription = null;
        this.ws = null;
        this.reconnectInterval = null;
        this.isConnected = false;
        this.userProfileId = parseInt(document.querySelector('meta[name="user-profile-id"]')?.getAttribute('content'));
        this.userLevelId = parseInt(document.querySelector('meta[name="user-level-id"]')?.getAttribute('content')) || 7;
    }
    initWebSocket() {
        if (!this.userProfileId) {
            console.error('User profile ID not found');
            return;
        }

        const protocol = window.location.protocol === 'https:' ? 'wss:' : 'ws:';
        const wsUrl = `${protocol}//${window.location.host}/graphql/subscriptions`;
        
        try {
            this.ws = new WebSocket(wsUrl);
            this.setupWebSocketHandlers();
        } catch (error) {
            console.error('WebSocket connection failed:', error);
            this.scheduleReconnect();
        }
    }

    setupWebSocketHandlers() {      
        this.ws.onopen = () => {
            console.log('WebSocket connected');
            this.isConnected = true;
            this.clearReconnectInterval();
            this.subscribeToMessages();
        };

        this.ws.onmessage = (event) => {
            const data = JSON.parse(event.data);
            this.handleIncomingMessage(data);
        };

        this.ws.onclose = () => {
            console.log('WebSocket disconnected');
            this.isConnected = false;
            this.scheduleReconnect();
        };

        this.ws.onerror = (error) => {
            console.error('WebSocket error:', error);
            this.isConnected = false;
        };
    }

    subscribeToMessages() {
        const subscriptionQuery = {
            id: '1',
            type: 'start',
            payload: {
                query: `
                    subscription MessageCreated($user_profile_id: ID!) {
                        messageCreated(user_profile_id: $user_profile_id) {
                            id
                            isi
                            tgl_pesan
                            created_at
                            pengirim {
                                id
                                nama_lengkap
                                foto
                            }
                            penerima {
                                id
                                nama_lengkap
                                foto
                            }
                            jenis {
                                id
                                nama
                            }
                        }
                    }
                `,
                variables: {
                    user_profile_id: this.userProfileId
                }
            }
        };

        if (this.ws && this.ws.readyState === WebSocket.OPEN) {
            this.ws.send(JSON.stringify(subscriptionQuery));
        }
    }

    handleIncomingMessage(data) {
        if (data.type === 'data' && data.payload?.data?.messageCreated) {
            const newMessage = data.payload.data.messageCreated;
            this.processNewMessage(newMessage);
        }
    }

    processNewMessage(message) {
        const isRelevant = this.isMessageRelevant(message);
        
        if (isRelevant) {
            if (this.isCurrentConversation(message)) {
                this.appendMessageToChat(message);
            }
            
            this.updateConversationPreview(message);
            
            this.showNotification(message);
        }
    }

    isMessageRelevant(message) {
        return (
            String(message.penerima?.id) === String(this.userProfileId) ||
            String(message.pengirim?.id) === String(this.userProfileId)
        );
    }

    isCurrentConversation(message) {
        return (
            String(message.penerima?.id) === String(currentPenerimaId) ||
            String(message.pengirim?.id) === String(currentPenerimaId)
        );
    }

    appendMessageToChat(message) {
        const chatMessages = document.getElementById('chatMessages');
        if (!chatMessages) return;

        const isSent = String(message.pengirim?.id) === String(this.userProfileId);
        const messageHtml = this.createMessageHtml(message, isSent);
        
        chatMessages.insertAdjacentHTML('beforeend', messageHtml);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    createMessageHtml(message, isSent) {
        const avatar = message.pengirim?.foto 
            ? `<img src="${message.pengirim.foto}" alt="${message.pengirim.nama_lengkap}" class="avatar">`
            : `<div class="avatar bg-blue-500 text-white flex items-center justify-center">${message.pengirim?.nama_lengkap?.charAt(0).toUpperCase() || '-'}</div>`;

        return `
            <div class="message ${isSent ? 'sent' : 'received'} animate-fade-in" data-message-id="${message.id}">
                <div class="flex ${isSent ? 'flex-row-reverse' : 'flex-row'} items-start">
                    ${!isSent ? avatar : ''}
                    <div class="flex-1">
                        <div class="text-sm">${message.isi || '-'}</div>
                        <div class="text-xs text-gray-500 mt-1">${this.formatDate(message.created_at)}</div>
                    </div>
                    ${isSent ? avatar : ''}
                </div>
            </div>
        `;
    }

    updateConversationPreview(message) {
        const conversationItem = document.querySelector(`[onclick*="${message.pengirim?.id}"]`) || 
                                document.querySelector(`[onclick*="${message.penerima?.id}"]`);
        
        if (conversationItem) {
            const previewText = conversationItem.querySelector('.text-sm');
            if (previewText) {
                previewText.textContent = message.isi.substring(0, 50) + (message.isi.length > 50 ? '...' : '');
            }
            
            const parent = conversationItem.parentElement;
            parent.insertBefore(conversationItem, parent.firstChild);
            
            conversationItem.classList.add('bg-blue-50');
            setTimeout(() => {
                conversationItem.classList.remove('bg-blue-50');
            }, 3000);
        }
    }

    showNotification(message) {
        if (!this.isCurrentConversation(message)) {
            const senderName = message.pengirim?.nama_lengkap || 'Pengguna';
            const notification = new Notification(`Pesan baru dari ${senderName}`, {
                body: message.isi.substring(0, 100),
                icon: message.pengirim?.foto || '/default-avatar.png'
            });

            notification.onclick = () => {
                window.focus();
                this.selectConversationFromNotification(message.pengirim?.id, message.pengirim?.nama_lengkap);
            };
        }
    }

    selectConversationFromNotification(penerimaId, namaLengkap) {
        if (penerimaId) {
            selectConversation(penerimaId, namaLengkap, '');
        }
    }

    scheduleReconnect() {
        if (this.reconnectInterval) return;
        
        this.reconnectInterval = setInterval(() => {
            console.log('Attempting to reconnect...');
            this.initWebSocket();
        }, 5000);
    }

    clearReconnectInterval() {
        if (this.reconnectInterval) {
            clearInterval(this.reconnectInterval);
            this.reconnectInterval = null;
        }
    }

    formatDate(dateString) {
        return new Date(dateString).toLocaleString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    startPolling() {
        setInterval(async () => {
            if (!this.isConnected) {
                await this.checkForNewMessages();
            }
        }, 3000);
    }

    async checkForNewMessages() {
        try {
            const query = this.userLevelId === 4 
                ? `query { allPesan { id isi tgl_pesan created_at pengirim { id nama_lengkap foto } penerima { id nama_lengkap foto } } }`
                : `query { pesansByUserProfile(user_profile_id: ${this.userProfileId}) { id isi tgl_pesan created_at pengirim { id nama_lengkap foto } penerima { id nama_lengkap foto } } }`;

            const response = await fetch('/graphql', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ query })
            });

            const result = await response.json();
            if (result.data) {
                const messages = this.userLevelId === 4 ? result.data.allPesan : result.data.pesansByUserProfile;
                this.handlePollingMessages(messages);
            }
        } catch (error) {
            console.error('Polling error:', error);
        }
    }

    handlePollingMessages(messages) {
        const lastMessageId = parseInt(localStorage.getItem('lastMessageId') || '0');
        const newMessages = messages.filter(m => parseInt(m.id) > lastMessageId);
        
        newMessages.forEach(message => {
            this.processNewMessage(message);
        });
        
        if (newMessages.length > 0) {
            localStorage.setItem('lastMessageId', Math.max(...newMessages.map(m => parseInt(m.id))).toString());
        }
    }
    init() {
        if ('WebSocket' in window) {
            this.initWebSocket();
        } else {
            console.warn('WebSocket not supported, falling back to polling');
            this.startPolling();
        }

        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }

        this.addStyles();
    }

    addStyles() {
        const style = document.createElement('style');
        style.textContent = `
            .animate-fade-in {
                animation: fadeIn 0.3s ease-in;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .conversation-item.unread {
                background-color: #eff6ff;
                border-left: 4px solid #3b82f6;
            }
        `;
        document.head.appendChild(style);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.realtimeHandler = new RealtimeMessageHandler();
    window.realtimeHandler.init();
});
