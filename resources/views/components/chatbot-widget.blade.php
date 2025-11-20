<div id="chatbot-root" class="chatbot-root" aria-live="polite">
    <section class="chatbot-window" aria-label="Conversation avec l’assistant" data-chatbot-window>
        <header class="chatbot-window__header">
            <div>
                <p class="chatbot-window__title">Assistant Éco</p>
                <p class="chatbot-window__subtitle">Questions sur les produits, commandes ou navigation</p>
            </div>
            <button type="button" class="chatbot-close" data-chatbot-close aria-label="Fermer la fenêtre du chatbot">&times;</button>
        </header>

        <div class="chatbot-window__body">
            <div class="chatbot-messages" data-chatbot-messages>
                <div class="chatbot-bubble chatbot-bubble--bot">
                    👋 Bonjour ! Je peux vous aider pour les FAQ, produits, commandes ou trouver une page.
                </div>
            </div>
        </div>

        <footer class="chatbot-window__footer">
            <form class="chatbot-form" data-chatbot-form>
                <label class="sr-only" for="chatbot-input">Saisissez votre message</label>
                <input id="chatbot-input" type="text" name="message" placeholder="Posez votre question..." autocomplete="off" maxlength="1000" required>
                <button type="submit" class="chatbot-send" aria-label="Envoyer le message">
                    <span>Envoyer</span>
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M3 20v-5l9-3l-9-3V4l18 8z"/>
                    </svg>
                </button>
            </form>
        </footer>
    </section>

    <button type="button" class="chatbot-launcher" data-chatbot-toggle aria-label="Open chat assistant">
        <span class="chatbot-launcher__pulse"></span>
        <span class="chatbot-launcher__icon" aria-hidden="true">
            <svg viewBox="0 0 64 64" role="img" focusable="false">
                <path d="M22 14a10 10 0 0 1 20 0h8a4 4 0 0 1 4 4v18a14 14 0 0 1-14 14h-1.1L33 56l-5.9-6H26A14 14 0 0 1 12 36V18a4 4 0 0 1 4-4zm10-6a6 6 0 0 0-5.65 4h11.3A6 6 0 0 0 32 8zm-7 18a3 3 0 1 0 3 3a3 3 0 0 0-3-3zm14 0a3 3 0 1 0 3 3a3 3 0 0 0-3-3zm-7 8a6 6 0 0 0-6 6h12a6 6 0 0 0-6-6z" />
            </svg>
        </span>
    </button>
</div>

