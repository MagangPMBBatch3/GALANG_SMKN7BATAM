<style>
    #addPenerimaCards .user-card {
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 0.5rem;
        padding: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: border-color 0.3s ease;
    }
    #addPenerimaCards .user-card:hover {
        border-color: #3b82f6; /* blue-500 */
        background-color: #eff6ff; /* blue-100 */
    }
    #addPenerimaCards .user-card.selected {
        border-color: #2563eb; /* blue-600 */
        background-color: #dbeafe; /* blue-200 */
    }
    #addPenerimaCards .user-card img {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 9999px;
        object-fit: cover;
    }
    #addPenerimaCards .user-card .initials {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 9999px;
        background-color: #3b82f6;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1rem;
    }
    #chatMessages .message {
        max-width: 75%;
        margin-bottom: 1rem;
        padding: 0.875rem 1rem;
        border-radius: 1.125rem;
        clear: both;
        position: relative;
        transition: all 0.2s ease;
        word-wrap: break-word;
        line-height: 1.4;
    }
    #chatMessages .message.sent {
        background: linear-gradient(135deg, #a4f0e6 0%, #5eaddb 100%);
        color: #374151;
        margin-left: auto;
        margin-right: 0.5rem;
        border-bottom-right-radius: 0.25rem;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }
    #chatMessages .message.received {
        background-color: #ffffff;
        color: #374151;
        margin-left: 0.5rem;
        margin-right: auto;
        border-bottom-left-radius: 0.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }
    #chatMessages .message .avatar {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 0.75rem;
        border: 2px solid #e5e7eb;
    }
    #chatMessages .message.sent .avatar {
        margin-left: 0.75rem;
        margin-right: 0;
    }
    .delete-btn {
        opacity: 0;
        transition: opacity 0.2s ease;
        background: rgba(239, 68, 68, 0.9);
        border-radius: 50%;
        padding: 0.25rem;
    }
    .message:hover .delete-btn {
        opacity: 1;
    }
    .conversation-item {
        transition: all 0.2s ease;
        padding: 1rem;
        cursor: pointer;
    }
    .conversation-item:hover {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        transform: translateX(2px);
    }
    .conversation-item.active {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-left: 4px solid #3b82f6;
    }
    #chatMessages {
        background: linear-gradient(180deg, #f9fafb 0%, #f3f4f6 100%);
    }
    .message .timestamp {
        font-size: 0.75rem;
        opacity: 0.7;
        margin-top: 0.25rem;
    }
    .message.sent .timestamp {
        text-align: right;
    }
    @media (max-width: 768px) {
        #chatMessages .message {
            max-width: 85%;
            padding: 1rem;
        }
        .conversation-item {
            padding: 1.25rem 1rem;
        }
        .delete-btn {
            opacity: 0;
        }
        .message:hover .delete-btn,
        .message:active .delete-btn {
            opacity: 1;
        }
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .loading-dots {
        display: inline-block;
    }
    .loading-dots::after {
        content: '...';
        animation: pulse 1.5s infinite;
    }
    #chatMessages::-webkit-scrollbar,
    #sidebar::-webkit-scrollbar {
        width: 6px;
    }
    #chatMessages::-webkit-scrollbar-track,
    #sidebar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    #chatMessages::-webkit-scrollbar-thumb,
    #sidebar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    #chatMessages::-webkit-scrollbar-thumb:hover,
    #sidebar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>