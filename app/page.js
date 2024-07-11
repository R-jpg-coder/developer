import Explore from "@/src/components/Explore";
import Gallery from "@/src/components/Gallery";
import MasterClass from "@/src/components/MasterClass";
import Review from "@/src/components/Review";

import Footer from "@/src/components/common/Footer";
import Header from "@/src/components/common/Header";
import Concept from "@/src/components/Concept";
import EventPartener from "@/src/components/EventPartner";
import GuidanceHeading from "@/src/components/GuidanceHeading";
import GuidenceStep from "@/src/components/GuidenceStep";
import HomeAboutUs from "@/src/components/HomeAboutUs";
import Video from "@/src/components/Video";
import Visual from "@/src/components/Visuals";

export const metadata = {
  title: "Home - Massart",
  description: "Welcome to the home of Massart.",
};

export default function Home() {
  return (
    <div className="bg-[#FFFFFF]">
      <Header />
      <main>
        <HomeAboutUs />
        <Visual />
        <Gallery />
        <Concept />
        <Video />
        <Explore />
        <MasterClass />
        <EventPartener />
        <Review />
        <GuidanceHeading />
        <GuidenceStep />
      </main>
      <Footer />
    </div>
  );
}
