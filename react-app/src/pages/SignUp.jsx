import React from "react";
import { useState, useRef, useEffect } from "react";
import { Link } from "react-router-dom";
import Header from "../partials/Header";
import PageIllustration from "../partials/PageIllustration";
import Global from "./../helpers/Global";
import { useNavigate } from "react-router-dom";

function SignUp() {
  const [firstName, setFirstName] = useState('');
  const [lastName, setLastName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');

  const [errors, setErrors] = useState({});
  const navigate = useNavigate();

  const onFormSubmit = async () => {
    try {
      const body = new FormData();
      body.append("first_name", firstName);
      body.append("last_name", lastName);
      body.append("email", email);
      body.append("password", password);
      body.append("password_confirmation", confirmPassword);

      let result = await Global.netowrkRequest("register", body, false);
      result = await result.json();

      if (!result.status) {
        setErrors(result.errors);
        return
      }

      Global.saveDataInLocalStorage('token', result?.data?.access_token);
      Global.saveDataInLocalStorage('user', JSON.stringify(result?.data?.user));
      navigate("/home");

    } catch (e) {
      console.log(e);
    }
  };

  return (
    <div className="flex flex-col min-h-screen overflow-hidden">
      <Header />

      <main className="grow">
        <div
          className="relative max-w-6xl mx-auto h-0 pointer-events-none"
          aria-hidden="true"
        >
          <PageIllustration />
        </div>

        <section className="relative">
          <div className="max-w-6xl mx-auto px-4 sm:px-6">
            <div className="pt-32 pb-12 md:pt-40 md:pb-20">
              <div className="max-w-3xl mx-auto text-center pb-12 md:pb-20">
                <h1 className="h1">
                  Welcome back. We exist to make news easier.
                </h1>
              </div>

              <div className="max-w-sm mx-auto">
                <form>
                  <div className="flex flex-wrap -mx-3 mb-4">
                    <div className="w-full px-3">
                      <label
                        className="block text-gray-300 text-sm font-medium mb-1"
                        htmlFor="first-name"
                      >
                        First Name <span className="text-red-600">*</span>
                      </label>
                      <input
                        id="first-name"
                        type="text"
                        className="form-input w-full text-gray-300 peer"
                        placeholder="First name"
                        onChange={(e) => setFirstName(e.target.value)}
                      />
                      {errors?.first_name?.[0] && (
                        <span className="text-sm text-red-600">
                          {errors?.first_name?.[0]}
                        </span>
                      )}
                    </div>
                  </div>
                  <div className="flex flex-wrap -mx-3 mb-4">
                    <div className="w-full px-3">
                      <label
                        className="block text-gray-300 text-sm font-medium mb-1"
                        htmlFor="last-name"
                      >
                        Last Name <span className="text-red-600">*</span>
                      </label>
                      <input
                        id="last-name"
                        type="text"
                        className="form-input w-full text-gray-300"
                        placeholder="Last name"
                        onChange={(e) => setLastName(e.target.value)}
                      />
                      {errors?.last_name?.[0] && (
                        <span className="text-sm text-red-600">
                          {errors?.last_name?.[0]}
                        </span>
                      )}
                    </div>
                  </div>

                  <div className="flex flex-wrap -mx-3 mb-4">
                    <div className="w-full px-3">
                      <label
                        className="block text-gray-300 text-sm font-medium mb-1"
                        htmlFor="email"
                      >
                        Email <span className="text-red-600">*</span>
                      </label>
                      <input
                        id="email"
                        type="email"
                        className="form-input w-full text-gray-300"
                        placeholder="you@yourcompany.com"
                        onChange={(e) => setEmail(e.target.value)}
                      />
                      {errors?.email?.[0] && (
                        <span className="text-sm text-red-600">
                          {errors?.email?.[0]}
                        </span>
                      )}
                    </div>
                  </div>
                  <div className="flex flex-wrap -mx-3 mb-4">
                    <div className="w-full px-3">
                      <label
                        className="block text-gray-300 text-sm font-medium mb-1"
                        htmlFor="password"
                      >
                        Password <span className="text-red-600">*</span>
                      </label>
                      <input
                        id="password"
                        type="password"
                        className="form-input w-full text-gray-300"
                        placeholder="Password (at least 10 characters)"
                        maxLength="10"
                        onChange={(e) => setPassword(e.target.value)}
                      />
                      {errors?.password?.[0] && (
                        <span className="text-sm text-red-600">
                          {errors?.password?.[0]}
                        </span>
                      )}
                    </div>
                  </div>
                  <div className="flex flex-wrap -mx-3 mb-4">
                    <div className="w-full px-3">
                      <label
                        className="block text-gray-300 text-sm font-medium mb-1"
                        htmlFor="confirm-password"
                      >
                        Confirm Password <span className="text-red-600">*</span>
                      </label>
                      <input
                        id="confirm-password"
                        type="password"
                        className="form-input w-full text-gray-300"
                        placeholder="Password (at least 10 characters)"
                        maxLength="10"
                        onChange={(e) => setConfirmPassword(e.target.value)}
                      />
                    </div>
                  </div>
                  <div className="flex flex-wrap -mx-3 mt-6">
                    <div className="w-full px-3">
                      <button
                        onClick={onFormSubmit}
                        type="button"
                        className="btn text-white bg-purple-600 hover:bg-purple-700 w-full"
                      >
                        Sign up
                      </button>
                    </div>
                  </div>
                </form>
                <div className="text-gray-400 text-center mt-6">
                  Already have an account?{" "}
                  <Link
                    to="/signin"
                    className="text-purple-600 hover:text-gray-200 transition duration-150 ease-in-out"
                  >
                    Sign in
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>
  );
}

export default SignUp;
