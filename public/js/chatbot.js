(() => {
    const root = document.getElementById('chatbot-root');
    if (!root) {
        return;
    }

    const config = window.ChatbotConfig ?? {};
    const launcher = root.querySelector('[data-chatbot-toggle]');
    const closeBtn = root.querySelector('[data-chatbot-close]');
    const windowEl = root.querySelector('[data-chatbot-window]');
    const form = root.querySelector('[data-chatbot-form]');
    const input = form?.querySelector('input');
    const messages = root.querySelector('[data-chatbot-messages]');

    const toggleWindow = () => {
        root.classList.toggle('is-open');
        if (root.classList.contains('is-open')) {
            input?.focus();
        }
    };

    const closeWindow = () => {
        root.classList.remove('is-open');
        launcher?.focus();
    };

    const appendMessage = (text, role = 'bot') => {
        if (!messages) {
            return;
        }
        const bubble = document.createElement('div');
        bubble.className = `chatbot-bubble chatbot-bubble--${role}`;
        bubble.textContent = text;
        messages.appendChild(bubble);
        messages.scrollTop = messages.scrollHeight;
    };

    const sendMessage = async (value) => {
        if (!config.endpoint) {
            appendMessage('Le service de chat n’est pas configuré.', 'bot');
            return;
        }

        form?.classList.add('is-loading');

        try {
            const response = await fetch(config.endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': config.csrf ?? document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                    'X-Current-Url': window.location.href,
                },
                body: JSON.stringify({ message: value }),
            });

            if (!response.ok) {
                throw new Error('Network error');
            }

            const data = await response.json();
            appendMessage(data.answer ?? 'Je ne parviens pas à répondre pour le moment.', 'bot');
        } catch (error) {
            appendMessage('Une erreur est survenue. Veuillez réessayer plus tard.', 'bot');
        } finally {
            form?.classList.remove('is-loading');
        }
    };

    launcher?.addEventListener('click', toggleWindow);
    closeBtn?.addEventListener('click', closeWindow);

    form?.addEventListener('submit', (event) => {
        event.preventDefault();
        const value = input?.value?.trim();
        if (!value) {
            return;
        }

        appendMessage(value, 'user');
        input.value = '';
        sendMessage(value);
    });

    document.addEventListener('keydown', (event) => {
        if (!root.classList.contains('is-open')) {
            return;
        }

        if (event.key === 'Escape') {
            closeWindow();
        }
    });

    if (config.greeting && messages?.children?.length === 1) {
        appendMessage(config.greeting, 'bot');
    }
})();

