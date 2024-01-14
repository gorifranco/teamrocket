export default function PostDisplay({data}) {


return (
        <div className={"my-5"}>
            <h2 className={"flex justify-center mb-6 text-2xl"}>{data.nom}</h2>
            <div className={"grid grid-cols-2 gap-10"}>
                <div className={"text-center"}>{data.descripcio}</div>
                <div className={"bg-amber-100 text-center"}> FOTO </div>
            </div>
        </div>

    )
}
