import { useState } from 'react';
import Dropdown from '@/Components/Dropdown';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';
import { Link } from '@inertiajs/react';
import '@inertiajs/react';
import ApplicationLogo from "@/Components/ApplicationLogo.jsx";
export default function Authenticated({ user, header, page_description, children }) {
    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);

    return (
        <div className="min-h-screen bg-gray-100">

            <nav className="border-b border-gray-100">
                <div className="max-w-7xl mx-auto lg:px-8 ">
                    <div className="flex h-16 items-center">
                        <div className="sm:flex flex-grow items-center justify-start ">
                            <Link href={route('platform.index')}>
                                <ApplicationLogo height={"6vh"}/>
                            </Link>
                        </div>


                        <div className="hidden sm:flex flex-grow items-center justify-end ms-auto">
                            <Dropdown>
                                <Dropdown.Trigger>
                                        <span className="bg-white rounded-md py-3 border border-black" >
                                            <button
                                                type="button"
                                                className="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {user.forename} {user.surname}
                                                <svg
                                                    className="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fillRule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clipRule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                </Dropdown.Trigger>

                                <Dropdown.Content>
                                    <Dropdown.Link href={route('profile.edit')}>Profile</Dropdown.Link>
                                    <Dropdown.Link href={route('logout')} method="post" as="button">Log Out</Dropdown.Link>
                                </Dropdown.Content>
                            </Dropdown>
                        </div>




                    </div>

                </div>


            </nav>


            <div className="">
                <nav className="bg-navy-blue mx-auto px-4 sm:px-6 lg:px-8 ">
                    <div className="flex sm:justify-center h-16">
                        <div className="flex">


                            <div className="hidden sm:flex sm:items-center sm:ms-6 space-x-8 ">
                                <NavLink className="bg-white rounded-md py-2 px-4 " href={route('dashboard')}
                                         active={route().current('dashboard')}>
                                    Dashboard
                                </NavLink>
                                <NavLink className="bg-white rounded-md py-2 px-4" href={route('dashboard')}
                                         active={route().current('dashboard')}>
                                    Pathways
                                </NavLink>
                                <NavLink className="bg-white rounded-md py-2 px-4" href={route('catalogue')}
                                         active={route().current('catalogue')}>
                                    Catalogue
                                </NavLink>
                                <NavLink className="bg-white rounded-md py-2 px-4" href={route('dashboard')}
                                         active={route().current('dashboard')}>
                                    Challenges
                                </NavLink>
                                <NavLink className="bg-white rounded-md py-2 px-4" href={route('dashboard')}
                                         active={route().current('dashboard')}>
                                    My Activity
                                </NavLink>
                                <NavLink className="bg-white rounded-md py-2 px-4" href={route('dashboard')}
                                         active={route().current('dashboard')}>
                                    Help
                                </NavLink>
                            </div>
                        </div>

                        <div className="me-2 flex items-center sm:hidden">
                            <button
                                onClick={() => setShowingNavigationDropdown((previousState) => !previousState)}
                                className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg className="h-6 w-6 justify-center" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        className={!showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        className={showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </nav>

                <div className={(showingNavigationDropdown ? 'block' : 'hidden') + ' sm:hidden'}>
                    <div className="pt-2 pb-3 space-y-1 ">
                        <ResponsiveNavLink href={route('dashboard')} active={route().current('dashboard')}>
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink href={route('dashboard')} active={route().current('dashboard')}>
                            Pathways
                        </ResponsiveNavLink>
                        <ResponsiveNavLink href={route('catalogue')} active={route().current('catalogue')}>
                            Catalogue
                        </ResponsiveNavLink>
                        <ResponsiveNavLink href={route('dashboard')} active={route().current('dashboard')}>
                            Challenges
                        </ResponsiveNavLink>
                        <ResponsiveNavLink href={route('dashboard')} active={route().current('dashboard')}>
                            My Activity
                        </ResponsiveNavLink>
                        <ResponsiveNavLink href={route('dashboard')} active={route().current('dashboard')}>
                            Help
                        </ResponsiveNavLink>
                    </div>

                    <div className="pt-4 pb-1 border-t border-gray-200">
                        <div className="px-4">
                            <div className="font-medium text-base text-gray-800">{user.forename}</div>
                            <div className="font-medium text-sm text-gray-500">{user.email}</div>
                        </div>

                        <div className="mt-3 space-y-1">
                            <ResponsiveNavLink href={route('profile.edit')}>Profile</ResponsiveNavLink>
                            <ResponsiveNavLink method="post" href={route('logout')} as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </div>

            {header && (
                <div className="py-5 bg-gold">
                    <header className="bg-gold flex justify-center">
                        <div>{header}</div>
                    </header>
                    <header className="bg-gold flex justify-center">
                        <div>{page_description}</div>
                    </header>
                </div>

                )}

            <main>{children}</main>
        </div>
    );
}
