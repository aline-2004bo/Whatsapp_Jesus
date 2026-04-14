<x-app-layout>

<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-6">🔐 Seguridad</h2>

    <div id="credenciales" class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Dispositivos registrados</h3>
        <p class="text-gray-400 text-sm" id="sin-credenciales">Cargando...</p>
        <ul id="lista-credenciales" class="space-y-2"></ul>
    </div>

    <button onclick="registerBiometric()"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        ➕ Activar FaceID / Huella
    </button>

    <p id="status-ok"  class="mt-4 text-green-600 hidden">✔ Biometría registrada correctamente</p>
    <p id="status-err" class="mt-4 text-red-500 hidden">❌ Error al registrar biometría</p>

</div>

<script>
const ROUTES = {
    keysIndex:    '/webauthn/keys',
    storeOptions: '/webauthn/keys/options',
    store:        '/webauthn/keys',
    destroy:      (id) => `/webauthn/keys/${id}`,
    update:       (id) => `/webauthn/keys/${id}`,
};

const CSRF = '{{ csrf_token() }}';

// ── Cargar credenciales ────────────────────────────────────────────────────
async function cargarCredenciales() {
    const sinCred = document.getElementById('sin-credenciales');
    const lista   = document.getElementById('lista-credenciales');

    try {
        const res = await fetch(ROUTES.keysIndex, {
            headers: { 'Accept': 'application/json' }
        });

        if (!res.ok) {
            sinCred.textContent = 'No se pudieron cargar los dispositivos.';
            return;
        }

        // El paquete puede devolver un array directo o { data: [...] }
        const payload = await res.json();
        const keys = Array.isArray(payload) ? payload : (payload.data ?? []);

        lista.innerHTML = '';

        if (!keys.length) {
            sinCred.textContent = 'No tienes dispositivos biométricos registrados.';
            sinCred.classList.remove('hidden');
            return;
        }

        sinCred.classList.add('hidden');
        keys.forEach(key => {
            const li = document.createElement('li');
            li.className = 'flex items-center justify-between bg-gray-100 px-4 py-2 rounded-lg';
            li.innerHTML = `
                <span>🔑 ${key.name ?? 'Dispositivo'}
                    <span class="text-xs text-gray-400">
                        (${new Date(key.created_at).toLocaleDateString()})
                    </span>
                </span>
                <button data-id="${key.id}"
                    class="text-red-500 text-sm hover:underline eliminar-btn">
                    Eliminar
                </button>
            `;
            li.querySelector('.eliminar-btn')
              .addEventListener('click', () => eliminarCredencial(key.id, li));
            lista.appendChild(li);
        });

    } catch (err) {
        console.error('Error cargando credenciales:', err);
        sinCred.textContent = 'Error al cargar dispositivos.';
    }
}

async function registerBiometric() {
    const statusOk  = document.getElementById('status-ok');
    const statusErr = document.getElementById('status-err');
    statusOk.classList.add('hidden');
    statusErr.classList.add('hidden');

    if (!window.PublicKeyCredential) {
        alert('Tu navegador no soporta WebAuthn.');
        return;
    }

    const isSecure = window.location.protocol === 'https:'
                  || window.location.hostname === 'localhost'
                  || window.location.hostname === '::1';

    if (!isSecure) {
        alert('La biometría requiere:\n• http://localhost:8000\n• O HTTPS en producción');
        return;
    }

    // 1. Pedir el nombre ANTES de todo (el paquete lo requiere en el POST)
    const nombre = (prompt('¿Cómo quieres llamar a este dispositivo?', 'Mi dispositivo') ?? '').trim()
                 || 'Mi dispositivo';

    try {
        // 2. Obtener opciones del servidor
        const resOpts = await fetch(ROUTES.storeOptions, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
                'Content-Type': 'application/json',
            }
        });

        if (!resOpts.ok) {
            console.error('Error opciones:', await resOpts.text());
            statusErr.classList.remove('hidden');
            return;
        }

        const options = await resOpts.json();

        // 3. Decodificar base64url → Uint8Array
        options.publicKey.challenge = base64ToArray(options.publicKey.challenge);
        options.publicKey.user.id   = base64ToArray(options.publicKey.user.id);

        if (options.publicKey.excludeCredentials?.length) {
            options.publicKey.excludeCredentials = options.publicKey.excludeCredentials.map(c => ({
                ...c,
                id: base64ToArray(c.id),
            }));
        }

        // 4. Llamar al autenticador (Face ID / Huella)
        let credential;
        try {
            credential = await navigator.credentials.create({ publicKey: options.publicKey });
        } catch (credErr) {
            console.warn('Registro cancelado:', credErr);
            statusErr.classList.remove('hidden');
            return;
        }

        // 5. Serializar respuesta + incluir name en el mismo payload
        const payload = {
            name:  nombre,                                          // ← requerido por el paquete
            id:    credential.id,
            type:  credential.type,
            rawId: arrayToBase64(credential.rawId),
            response: {
                attestationObject: arrayToBase64(credential.response.attestationObject),
                clientDataJSON:    arrayToBase64(credential.response.clientDataJSON),
            }
        };

        // 6. Guardar en el servidor
        const resSave = await fetch(ROUTES.store, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            body: JSON.stringify(payload)
        });

        const saveData = await resSave.json().catch(() => null);

        if (!resSave.ok) {
            console.error('Error guardando:', saveData);
            statusErr.classList.remove('hidden');
            return;
        }

        statusOk.classList.remove('hidden');
        cargarCredenciales();

    } catch (err) {
        console.error('Error WebAuthn:', err);
        statusErr.classList.remove('hidden');
    }
}

// ── Eliminar credencial ────────────────────────────────────────────────────
async function eliminarCredencial(id, liElement) {
    if (!confirm('¿Eliminar este dispositivo biométrico?')) return;

    try {
        const res = await fetch(ROUTES.destroy(id), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            }
        });

        if (res.ok) {
            liElement.remove();
            const lista = document.getElementById('lista-credenciales');
            if (!lista.children.length) {
                const sinCred = document.getElementById('sin-credenciales');
                sinCred.textContent = 'No tienes dispositivos biométricos registrados.';
                sinCred.classList.remove('hidden');
            }
        } else {
            alert('No se pudo eliminar el dispositivo.');
        }
    } catch (err) {
        console.error('Error eliminando:', err);
        alert('Error de conexión al eliminar el dispositivo.');
    }
}

// ── Utilidades base64url ───────────────────────────────────────────────────
function base64ToArray(base64) {
    const b64 = base64.replace(/-/g, '+').replace(/_/g, '/');
    const bin = atob(b64);
    return Uint8Array.from(bin, c => c.charCodeAt(0));
}

function arrayToBase64(buffer) {
    return btoa(String.fromCharCode(...new Uint8Array(buffer)))
        .replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
}

// ── Iniciar ─────────────────────────────────────────────────────────────────
cargarCredenciales();
</script>

</x-app-layout>