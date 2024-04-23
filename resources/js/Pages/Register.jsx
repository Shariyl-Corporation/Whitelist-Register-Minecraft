import { Link, Head } from '@inertiajs/react';
import { Tooltip } from 'react-tooltip'
import TextInput from '@/Components/TextInput';
import { useForm } from '@inertiajs/react';
import { useRef } from 'react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import { Transition } from '@headlessui/react';



export default function Status({ message }) {
    const username = useRef();


    const { data, setData, errors, post, reset, processing, recentlySuccessful } = useForm({
        username: '',
    });

    const register = (e) => {
        e.preventDefault();

        post(route('user.register'), {
            preserveScroll: true,
            onSuccess: () => reset(),
            onError: (errors) => {
                console.log(errors);
            },
        });
    };

    return (
        <>
            <Head title="Status" />
            <div className="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
                
                <div className="max-w-7xl mx-auto p-6 lg:p-8">
                    <div className="flex justify-center">
                        <h1 className='text-xl'>Register Minecraft Bangkit</h1>
                    </div>

                    <div className="mt-16">
                        <div className="flex flex-col gap-6 lg:gap-8">
                            {/* <p>Username</p> */}
                            <form onSubmit={register} className="mt-6 space-y-6">
                                <div>
                                    <InputLabel htmlFor="username" value="Username" />
                                    <TextInput
                                        id="username"
                                        ref={username}
                                        value={data.username}
                                        onChange={(e) => setData('username', e.target.value)}
                                        // type="text"
                                        className="mt-1 block w-full"
                                    />

                                    <InputError message={errors.username} className="mt-2" />
                                </div>
                                <Transition
                                        show={recentlySuccessful}
                                        enter="transition ease-in-out"
                                        enterFrom="opacity-0"
                                        leave="transition ease-in-out"
                                        leaveTo="opacity-0"
                                    >
                                        <p className="text-sm text-gray-600 dark:text-gray-400">{message}</p>
                                    </Transition>
                                <div className="flex items-center gap-4 place-content-end">
                                    <PrimaryButton>Register</PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div className="flex justify-between mt-16 px-6 sm:items-center sm:justify-between">
                        <div className="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-start">
                            <div className="flex items-center gap-4">
                                <a
                                    href="https://github.com/Shariyl-Corporation/Server-Status"
                                    className="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        className="-mt-px me-1 w-5 h-5 dark:stroke-gray-600 group-hover:stroke-gray-600 dark:group-hover:stroke-gray-400"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"
                                        />
                                    </svg>
                                    Repository
                                </a>
                                <p>
                                    Built with Laravel and React
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <style>{`
                .bg-dots-darker {
                    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
                }
                @media (prefers-color-scheme: dark) {
                    .dark\\:bg-dots-lighter {
                        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
                    }
                }
            `}</style>
        </>
    );
}
