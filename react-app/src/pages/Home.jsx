import React, { useEffect, useState } from "react";
import Header from "../partials/Header";
import Global from "./../helpers/Global";
import PageIllustration from "../partials/PageIllustration";
import NewsCard from "../partials/NewsCard";
import Footer from "../partials/Footer";

function SignIn() {
  const [search, setSearch] = useState("");
  const [date, setDate] = useState("");
  const [category, setCategory] = useState("");
  const [data, setdata] = useState([]);

  const fetchData = async (forBody) => {
    const body = forBody ? forBody : new FormData();

    let results = await Global.netowrkRequest("fetch-news", body, true);
    results = await results.json();
    setdata(results.data);
  };

  useEffect(() => {
    fetchData();
  }, []);

  const onPressSearch = () => {
    const body = new FormData();

    if (search) {
      body.append("q", search);
    }

    if (date) {
      body.append("from", date);
    }

    if (category) {
      body.append("q", category);
    }

    fetchData(body);
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

        <section>
          <div className="max-w-6xl mx-auto px-4 sm:px-6">
            <div className="py-12 md:py-20">
              <div className="max-w-3xl mx-auto text-center pb-12 md:pb-20">
                <h2 className="h2 mb-4">
                  Watch customized and personalized News.
                </h2>
              </div>

              <form className="w-full">
                <div className="flex flex-wrap -mx-3 mb-6">
                  <div className="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label
                      className="block uppercase tracking-wide text-xs font-bold mb-2"
                      htmlFor="search"
                    >
                      Search
                    </label>
                    <input
                      className="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                      id="search"
                      type="text"
                      onChange={(e) => setSearch(e.target.value)}
                      placeholder="President biden"
                    />
                  </div>
                  <div className="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label
                      className="block uppercase tracking-wide text-xs font-bold mb-2"
                      htmlFor="search"
                    >
                      Date
                    </label>
                    <input
                      className="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                      id="search"
                      type="date"
                      onChange={(e) => setDate(e.target.value)}
                      max={new Date().toISOString().split("T")[0]}
                    />
                  </div>
                  <div className="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label
                      className="block uppercase tracking-wide text-xs font-bold mb-2"
                      htmlFor="category"
                    >
                      Category
                    </label>
                    <select
                      id="category"
                      onChange={(e) => setCategory(e.target.value)}
                      className="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    >
                      <option name="">-</option>
                      <option name="technology">Technology</option>
                      <option name="science">Science</option>
                      <option name="environmental">Environmental</option>
                    </select>
                  </div>
                  <div className="w-full md:w-1/4 m-auto">
                    <button
                      type="button"
                      onClick={onPressSearch}
                      className="rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                    >
                      Search
                    </button>
                  </div>
                </div>
              </form>

              <div
                className="max-w-sm mx-auto grid gap-8 md:grid-cols-2 lg:grid-cols-3 lg:gap-16 items-start md:max-w-2xl lg:max-w-none"
                data-aos-id-blocks
              >
                {data.map((item, index) => (
                  <NewsCard key={`news-${index}`} item={item} />
                ))}
              </div>
            </div>
          </div>
        </section>
      </main>

      <Footer />
    </div>
  );
}

export default SignIn;
